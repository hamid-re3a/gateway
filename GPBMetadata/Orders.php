<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: orders.proto

namespace GPBMetadata;

class Orders
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            '
�
orders.protoorders.services.grpc"B
Acknowledge
status (
message (	

created_at (	"
Id

id ("�
Order

id (
user_id (
from_user_id (
total_cost_in_pf (
packages_cost_in_pf (
registration_fee_in_pf (

is_paid_at (	
is_resolved_at (	
is_refund_at	 (	
validity_in_days
 (!
is_commission_resolved_at (	
payment_type (	
payment_currency (	
payment_driver (	.
plan (2 .orders.services.grpc.OrderPlans

deleted_at (	

created_at (	

updated_at (	

package_id (*k

OrderPlans
ORDER_PLAN_PURCHASE 
ORDER_PLAN_START
ORDER_PLAN_SPECIAL
ORDER_PLAN_COMPANY2c
OrdersServiceR
sponsorPackage.orders.services.grpc.Order!.orders.services.grpc.Acknowledge" bproto3'
        , true);

        static::$is_initialized = true;
    }
}

