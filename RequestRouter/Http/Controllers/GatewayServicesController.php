<?php

namespace RequestRouter\Http\Controllers;

use App\Http\Controllers\Controller;
use RequestRouter\Http\Requests\Admin\EditGatewayRequest;
use RequestRouter\Http\Resources\Gateway\GatewayServiceListResource;
use RequestRouter\Services\GatewayService;

class GatewayServicesController extends Controller
{

    private $gatewayService;

    public function __construct(GatewayService $gatewayService)
    {
        $this->gatewayService = $gatewayService;
    }

    /**
     * list gateway service list
     * @group
     * Admin > GatewayService
     * @return \Illuminate\Http\JsonResponse
     */
    public function gatewayServicesList()
    {
        $gateway_service_list = $this->gatewayService->getAllGatewayServices();

        return api()->success(trans('user.responses.ok'), GatewayServiceListResource::collection($gateway_service_list));

    }

    /**
     * edit gateway service items
     * @group
     * Admin > GatewayService
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
