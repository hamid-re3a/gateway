<?php
namespace RequestRouter\Repository;


use RequestRouter\Model\GatewayServices;

class GatewayServiceRepository
{
    private $entity_name = GatewayServices::class;

    public function getAllGatewayServices()
    {
        $gateway_service_entity = new $this->entity_name;
        return $gateway_service_entity->all();
    }

    public function edit($service_gateway)
    {
        $gateway_service_entity = new $this->entity_name;
        $service_find = $gateway_service_entity->whereId($service_gateway->service_id)->first();
        $service_find->name = $service_gateway->name ?? $service_find->name;
        $service_find->doc_point = $service_gateway->doc_point ?? $service_find->doc_point;
        $service_find->just_current_routes = $service_gateway->just_current_routes ?? $service_find->just_current_routes;
        $service_find->domain = $service_gateway->domain ?? $service_find->domain;
        if (!empty($service_find->getDirty())) {
            $service_find->save();
        }
        return $service_find;
    }
}
