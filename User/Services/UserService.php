<?php


namespace User\Services;

use User\Repository\UserRepository;
use User\Services\Grpc\Id;
use User\Services\Grpc\WalletInfo;
use User\Services\Grpc\WalletRequest;
use User\Services\Grpc\WalletType;

class UserService
{
    private $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function getUserById(Id $id)
    {
        return $this->user_repository->getUserData($id->getId());
    }

    public function getUserByMemberId(Id $id)
    {
        return $this->user_repository->getUserDataByMemberId($id->getId());
    }

    public function getUserWalletInfo(WalletRequest $walletRequest)
    {
        $id = $walletRequest->getUserId();
        $crypto_name = WalletType::name($walletRequest->getWalletType());
        $wallet = $this->user_repository->getUserWallet($id,$crypto_name);
        $wallet_object = new WalletInfo();
        if(!$wallet)
            return $wallet_object;

        $wallet_object->setAddress($wallet->address);
        $wallet_object->setWalletType($walletRequest->getWalletType());

        return $wallet_object;
    }
}
