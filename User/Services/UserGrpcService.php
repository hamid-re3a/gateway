<?php


namespace User\Services;

use Mix\Grpc\Context;

class UserGrpcService implements UserServiceInterface
{
    /**
     * @inheritDoc
     */
    public function getUserById(Context $context, Id $request): User
    {
        return \User\Models\User::query()->find($request->getId())->getUserService();
    }
}
