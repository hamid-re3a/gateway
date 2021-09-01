<?php

namespace RequestRouter\Http\Controllers;


use App\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use RequestRouter\Http\Resources\GatewayServicesKeysResource;
use RequestRouter\Http\Resources\GatewayServicesResource;
use \Symfony\Component\HttpFoundation\Request as SymRequest;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use User\Models\User;
use User\Services\GatewayService;

class GatewayController extends Controller
{
    private $gateway_services;

    public function __construct(GatewayService $gateway_services)
    {
        $this->gateway_services = $gateway_services;
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function requestRouter(Request $request)
    {
        $route = str_replace('api/gateway/', '', $request->path());
        list($status, $final_route, $middlewares) = $this->getValidRoute($route, $request);
        $response = $this->checkMiddlewares($middlewares, $request);
        $this->setUserHeadersIfAuthenticated($request);
        if (!is_null($response)) {
            return $response;
        }

        if ($status == true) {
            return $this->getResponse($final_route, $request);
        }
        return api()->error('request_router.responses.not-found', null, 404);


    }


    /**
     * @hideFromAPIDocumentation
     */
    public function multiAggregate(Request $request)
    {
        $rules = [
            'routes' => 'required|array',
            'routes.*.route' => 'required',
            'routes.*.method' => 'required',
        ];
        $validated = Validator::validate($request->all(), $rules);


        $middlewares = [];

        $concurrent_requests = [];
        $concurrent_responses = [];
        foreach ($validated['routes'] as $route) {
            $route_method = strtolower($route['method']);
            list($status, $final_route, $route_middlewares) = $this->getValidRoute($route['route'], $request, $route_method);
            if (!is_null($route_middlewares))
                $middlewares = array_merge($middlewares, $route_middlewares);

            if ($status)
                if (Str::startsWith($final_route, URL::to('/'))) {
                    $concurrent_responses[$route['route']] = $this->getResponse($final_route, $request, $route_method, true);
                } else {
                    $concurrent_requests[] = ['route' => $final_route, 'method' => $route_method, 'name' => $route['route']];
                }
        }
        $response = $this->checkMiddlewares($middlewares, $request);
        $this->setUserHeadersIfAuthenticated($request);

        if (!is_null($response)) {
            return $response;
        }
        $headers = $this->getNecessaryHeaders($request);
        $user_agent = $request->userAgent();
        $contents = $request->getContent();
        $content_type = $request->getContentType() ?? "application/json";

        $responses = Http::withHeaders($headers)
            ->withBody($contents, $content_type)
            ->withUserAgent($user_agent)->pool(function (\Illuminate\Http\Client\Pool $pool) use ($concurrent_requests, $request) {
                $array = [];
                foreach ($concurrent_requests as $route) {
                    $array[] = $pool->as($route['name'])->get($route['route']);
                }

                return $array;
            });


        foreach ($concurrent_requests as $route) {
            $concurrent_responses[$route['name']] = json_decode($responses[$route['name']]->body(), true);
        }

        header('Content-type: application/json');
        return api()->success('success', $concurrent_responses);

    }


    /**
     * @param $route
     * @param $request
     * @param null $method
     * @return array
     * @todo change config from database
     */
    private function getValidRoute($route, $request, $method = null)
    {
        if (is_null($method))
            $method = strtolower($request->method());

        $routes = config('gateway.routes');
        $services = config('gateway.services');
        $service_keys = collect(config('gateway.services'))->keys()->toArray();
//        $services = GatewayServicesResource::collection($this->gateway_services->getAllGatewayServices())->resolve();
//        $services = array_replace(...$services);
//        $service_keys = GatewayServicesKeysResource::collection($this->gateway_services->getAllGatewayServices())->response()->getData();
        if (Str::startsWith($route, '/'))
            return [false, null, null];
        if (preg_match('/^^(?!\W)((?P<service>.*?)(?=\/)\/(?P<route>.*)|(?P<second_service>.*))$/', $route, $match)) {

            $service = (is_null($match['service']) || empty($match['service'])) ? $match['second_service'] : $match['service'];
            $sub_route = $match['route'] ?? '';

            if ($service == 'default')
                return [true, URL::to('/api') . '/' . $sub_route, null];


            if (in_array($service, $service_keys)) {
                $domain = $services[$service]['domain'];
                $final_route = $domain . $sub_route;


                list($can_pass, $middlewares) = $this->checkRouteForPossibleMiddlewares($routes, $service, $route, $method, $sub_route);

                if ($can_pass || !$services[$service]['just_current_routes']) {
                    return [true, $final_route, $middlewares];
                }

            }
            return [false, null, null];


        }
    }

    private function checkMiddlewares($middlewares, Request $request)
    {
        if (!is_array($middlewares) || count($middlewares) <= 0)
            return null;

        $kernel = app()->make(Kernel::class);
        foreach ($middlewares as $middleware) {
            $mid = explode(':', $middleware);
            $name = $mid[0];
            $arg = '';
            if (isset($mid[1]))
                $arg = $mid[1];

            $res = app()->make($kernel->getRouteMiddleware()[$name])->handle($request, function () {
                return null;
            }, $arg);

            if (!is_null($res))
                return $res;
        }

        return null;
    }

    /**
     * @param $routes
     * @param $service
     * @param $route
     * @param string $method
     * @param $sub_route
     * @return array
     */
    private function checkRouteForPossibleMiddlewares($routes, $service, $route, string $method, $sub_route)
    {
        foreach ($routes as $c_route)
            if (in_array($service, $c_route['services']) || $c_route['services'] = '*')
                foreach ($c_route['matches'] as $match_route)
                    if ($method == strtolower($match_route['method']) || strtolower($match_route['method']) == '*')
                        foreach ($match_route['paths'] as $path)
                            if ($path == '*' || preg_match('/' . $path . '/', $sub_route)) {
                                $exception_flag = false;
                                if (isset($match_route['exceptions_paths'])) {
                                    foreach ($match_route['exceptions_paths'] as $exception) {
                                        if (preg_match('/' . $exception . '/', $sub_route)) {
                                            $exception_flag = true;
                                        }
                                    }
                                }
                                if ($exception_flag)
                                    continue;


                                $middlewares = [];
                                if (isset($match_route['middlewares'])) {
                                    $middlewares = array_merge($middlewares, $match_route['middlewares']);
                                }
                                if (isset($c_route['middlewares'])) {
                                    $middlewares = array_merge($middlewares, $c_route['middlewares']);
                                }
                                return [true, $middlewares];
                            }
        return [false, null];
    }


    private function getResponse($final_route, Request $request, $method = null, $multi = false)
    {

        if (is_null($method))
            $method = strtolower($request->method());

        if ($request->getQueryString())
            $final_route .= '?' . $request->getQueryString();
        if (Str::startsWith($final_route, URL::to('/'))) {
            $request = Request::create($final_route, $method, $request->all(), $request->cookie(), $request->allFiles(), $request->server->all(), $request->getContent());
            return Route::dispatch($request);
        }
        $user_agent = $request->userAgent();
        $contents = $request->getContent();
        $content_type = $request->header('Content-type') ?? $request->getContentType() ?? "application/json";

        $headers = $this->getNecessaryHeaders($request);
        $req = Http::withHeaders($headers)->withUserAgent($user_agent);

        if (Str::startsWith($content_type, 'multi')) {

            $multipart = [];
            foreach ($request->all() as $key => $file) {
                if (is_array($file))
                    foreach ($file as $subFile) {
                        $this->attachFile($multipart, $key . '[]', $subFile);
                    }
                else if ($file instanceof UploadedFile)
                    $this->attachFile($multipart, $key, $file);

                else
                    $this->attachContent($multipart, $key, $file);
            }
            try {
                $res = (new \GuzzleHttp\Client(['headers' => $headers]))->$method(
                    $final_route,
                    ['multipart' => $multipart]
                );
            } catch (\GuzzleHttp\Exception\RequestException $exception) {
                return new Response($exception->getResponse()->getBody(), $exception->getResponse()->getStatusCode(), $exception->getResponse()->getHeaders());
            }
            return new Response($res->getBody()->getContents(), $res->getStatusCode(), $res->getHeaders());
        }
        $req->withBody($contents, $content_type);


        $res = $req->$method($final_route);
        if (in_array($res->header('Content-type'), ALL_MIME_TYPES)) {
            if (!$multi)
                foreach ($res->headers() as $key => $value)
                    header("$key: $value");
            echo $res->body();
            return null;
        }
        $final = response($res->body(), $res->status());
        if (!$multi)
            foreach ($res->headers() as $key => $value)
                $final->header($key, $value);
        return $final;
    }

    private function injectParams($url, array $params, $prefix = '')
    {
        foreach ($params as $key => $value) {
            if (is_string($value) || is_numeric($value)) {
                if (Str::contains($url, '?'))
                    $url = $url . "&$key=$value";
                else
                    $url = $url . "?$key=$value";
            }
        }

        return $url;
    }

    /**
     * @param Request $request
     */
    private function setUserHeadersIfAuthenticated(Request $request): void
    {
        $request->headers->remove('X-user-id');

        $request->headers->remove('X-user-first-name');
        $request->headers->remove('X-user-last-name');
        $request->headers->remove('X-user-email');
        $request->headers->remove('X-user-username');
        $request->headers->remove('X-user-member-id');
        $request->headers->remove('X-user-sponsor-id');
        $request->headers->remove('X-user-is-freeze');
        $request->headers->remove('X-user-is-deactivate');
        $request->headers->remove('X-user-block-type');
        if (auth()->check()) {
            $user = User::query()->find(auth()->user()->id);

            $request->headers->set('X-user-id', $user->id);
            $user_service = $user->getUserService();
            $hash = \Illuminate\Support\Facades\Hash::make($user_service);
            $request->headers->set('X-user-hash', $hash);
            $request->headers->set('X-user-first-name', $user->first_name);
            $request->headers->set('X-user-last-name', $user->last_name);
            $request->headers->set('X-user-email', $user->email);
            $request->headers->set('X-user-username', $user->username);
            $request->headers->set('X-user-member-id', $user->member_id);
            $request->headers->set('X-user-sponsor-id', $user->sponsor_id);
            $request->headers->set('X-user-is-freeze', $user->is_freeze);
            $request->headers->set('X-user-is-deactivate', $user->is_deactivate);
            $request->headers->set('X-user-block-type', $user->block_type);
        }
    }


    private function getNecessaryHeaders(Request $request): array
    {
        $headers = collect($request->header())->transform(function ($item) {
            return $item[0];
        })->toArray();
        unset($headers['accept-language']);
        unset($headers['accept-encoding']);
        unset($headers['sec-fetch-dest']);
        unset($headers['sec-fetch-user']);
        unset($headers['sec-fetch-mode']);
        unset($headers['sec-fetch-site']);
//        unset($headers['accept']);
        unset($headers['user-agent']);
        unset($headers['upgrade-insecure-requests']);
        unset($headers['sec-ch-ua-mobile']);
        unset($headers['sec-ch-ua']);
        unset($headers['cache-control']);
        unset($headers['connection']);
        unset($headers['host']);
        unset($headers['content-length']);
//        unset($headers['content-type']);
        unset($headers['cookie']);
        return $headers;
    }


    private function attachFile(&$multipart, $key, $subFile)
    {
        $file = fopen($subFile->getRealPath(), 'r');
        $multipart[] = ['name' => $key, 'contents' => $file, 'filename' => $subFile->getClientOriginalName(), [
            'Content-Type' => $subFile->getMimeType()
        ]];
    }

    private function attachContent(&$multipart, $key, $conent)
    {
        $multipart[] = ['name' => $key, 'contents' => $conent];
    }

    function sanitizeArray($array)
    {
        static $newArray = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                sanitizeArray($value);
            } else {
                $newArray[$key] = $value;
            }
        }
        return $newArray;
    }
}
