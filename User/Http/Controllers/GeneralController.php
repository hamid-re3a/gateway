<?php

namespace User\Http\Controllers;


use Illuminate\Routing\Controller;
use User\Http\Requests\Globally\CitiesRequest;
use User\Http\Requests\Globally\StatesRequest;
use User\Http\Resources\CityResource;
use User\Http\Resources\CountryResource;
use User\Models\City;
use User\Models\Country;

class GeneralController extends Controller
{

    /**
     * Countries list
     * @group General
     * @unauthenticated
     * @return \Illuminate\Http\JsonResponse
     */
    public function countries()
    {
        return api()->success(null,CountryResource::collection(Country::all()));
    }

    /**
     * States list
     * @group General
     * @unauthenticated
     * @param StatesRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function states(StatesRequest $request)
    {
        $country = Country::query()->find($request->get('country_id'));
        return api()->success(null,CityResource::collection($country->states()->get()));
    }

    /**
     * Cities list
     * @group General
     * @unauthenticated
     * @param CitiesRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cities(CitiesRequest $request)
    {
        $state = City::query()->where('id',$request->get('state_id'))->with('cities')->first();

        return api()->success(null,CityResource::collection($state->cities));
    }
}
