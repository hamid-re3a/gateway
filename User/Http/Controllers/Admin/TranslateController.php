<?php


namespace User\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse as JsonResponseAlias;
use User\Http\Requests\Admin\ShowTranslateRequest;
use User\Http\Requests\Admin\StoreTranslateRequest;
use User\Http\Requests\Admin\UpdateTranslateRequest;
use User\Http\Resources\TranslateResource;
use User\Models\Translate;
use User\Services\TranslateService;

class TranslateController extends Controller
{
    private $translate_service;

    public function __construct(TranslateService $translate_service)
    {
        $this->translate_service = $translate_service;
    }
    /**
     * List translates
     * @group Admin > Translates
     *
     */
    public function index()
    {
        return api()->success(null,TranslateResource::collection($this->translate_service->list())->response()->getData());

    }

    /**
     * List unfinished translates
     * @group Admin > Translates
     */
    public function unfinished()
    {

        return api()->success(null,TranslateResource::collection(Translate::whereNull('value')->simplePaginate())->response()->getData());

    }

    /**
     * Create a translate
     * @group Admin > Translates
     * @param StoreTranslateRequest $request
     * @return JsonResponseAlias
     */
    public function store(StoreTranslateRequest $request)
    {

        $translate = Translate::create([
            'key' => $request->get('key'),
            'value' => $request->get('value')
        ]);
        $this->cacheAllTranslates();

        return api()->success(null,TranslateResource::make($translate));

    }

    /**
     * Get a translate
     * @group Admin > Translates
     * @param ShowTranslateRequest $request
     * @return JsonResponseAlias
     */
    public function show(ShowTranslateRequest $request)
    {

        return api()->success(null,TranslateResource::make(Translate::where('key',$request->get('key'))->first()));

    }

    /**
     * Update a translate
     * @group Admin > Translates
     * @param UpdateTranslateRequest $request
     * @return JsonResponseAlias
     */
    public function update(UpdateTranslateRequest $request)
    {

        $translate = Translate::where('key',$request->get('key'))->first();
        $translate->update([
            'value' => $request->get('value')
        ]);
        $this->cacheAllTranslates();

        return api()->success(null, TranslateResource::make($translate));

    }

    /**
     * Remove a translate
     * @group Admin > Translates
     * @param ShowTranslateRequest $request
     * @return JsonResponseAlias
     */
    public function destroy(ShowTranslateRequest $request)
    {

        Translate::where('key',$request->get('key'))->delete();
        $this->cacheAllTranslates();

        return api()->success(trans('user.responses.ok'));

    }

    private function cacheAllTranslates()
    {
        if(cache()->has('dbTranslates'))
            cache()->delete('dbTranslates');

        cache()->rememberForever('dbTranslates', function(){
            return Translate::select(['key','value'])->get();
        });

    }

}
