<?php
namespace User\Repository;

use Spatie\Permission\Models\Role;
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

    public function update(\User\Services\User $user)
    {
        $user_entity = new $this->entity_name;
        $user_find = $user_entity->query()->find($user->getId());
        if($user_find) {
            $user_find->update([
                'id' => $user->getId(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'member_id' => $user->getMemberId(),
                'block_type' => empty($user->getBlockType()) ? null : $user->getBlockType(),
                'is_deactivate' => empty($user->getIsDeactivate()) ? false : $user->getIsDeactivate(),
                'is_freeze' => empty($user->getIsFreeze()) ? false : $user->getIsFreeze(),
                'sponsor_id' => empty($user->getSponsorId()) ? null : $user->getSponsorId(),
            ]);

            $user_find->roles()->detach();
            $roles = explode(",", $user->getRole());
            foreach ($roles as $role) {
                $roleExist = Role::whereName($role)->first();
                if ($roleExist === null) {
                    $role = Role::create(['name' => $role, 'guard_name' => 'api']);
                    $user_find->assignRole($role);
                } else {
                    $user_find->assignRole($roleExist);
                }
            }

            return $user_find->getUserService();

        }

        return false;

    }
}
