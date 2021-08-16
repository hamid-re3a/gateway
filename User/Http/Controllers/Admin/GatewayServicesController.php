<?php

namespace User\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use User\Http\Requests\Admin\EditGatewayRequest;
use User\Http\Resources\Gateway\GatewayServiceListResource;
use User\Services\GatewayService;

class GatewayServicesController extends Controller
{

    private $gatewayService;

    public function __construct(GatewayService $gatewayService)
    {
        $this->gatewayService = $gatewayService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function gatewayServicesList()
    {
        $gateway_service_list = $this->gatewayService->getAllGatewayServices();

        return api()->success(trans('user.responses.ok'), GatewayServiceListResource::collection($gateway_service_list));

    }

    /**
     * @todo  make object serviceGateway and use that
     * @param EditGatewayRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editServiceGateway(EditGatewayRequest $request)
    {
        $gateway_service_list = $this->gatewayService->editGatewayService($request);


        return api()->success(trans('user.responses.ok'), new GatewayServiceListResource($gateway_service_list));

    }

}
