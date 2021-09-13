<?php
namespace User\Repository;

use User\Models\GatewayServices;
use User\Models\User;

class UserRepository
{
    private $entity_name = User::class;

    public function createAdmin($request)
    {
        $user_entity = new $this->entity_name;
        $user_entity->first_name = $request->first_name;
        $user_entity->last_name = $request->last_name;
        $user_entity->email = $request->email;
        $user_entity->email_verified_at = now();
        $user_entity->username = $request->username;
        $user_entity->sponsor_id = $request->sponsor_id;
        $user_entity->password = encrypt($request->password);
        $user_entity->save();
        return $user_entity;
    }

    public function getUserData($id)
    {
        $user_entity = new $this->entity_name;
        $user_entity->whereId($id)->first();
        return $user_entity->getUserService();
    }
}
