<?php


namespace User\Services\Grpc;

use Mix\Grpc;
use Mix\Grpc\Context;

class UserGrpcService implements UserServiceInterface
{

    private $user_service;

    public function __construct()
    {
        $this->user_service = app(UserService::class);
    }

    /**
     * @inheritDoc
     */
    public function getUserById(Context $context, Id $request): User
    {
        return $this->user_service->getUserById($request);
    }

    /**
     * @inheritDoc
     */
    public function getUserWalletInfo(Context $context, WalletRequest $request): WalletInfo
    {
        return $this->user_service->getUserWalletInfo($request);
    }
}
