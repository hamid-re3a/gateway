<?php


namespace User\Services;

use Illuminate\Support\Str;
use User\Http\Requests\User\SponsorUserRequest;
use User\Jobs\UrgentEmailJob;
use User\Mail\User\WelcomeWithPasswordEmail;
use User\Models\User;
use User\Repository\UserRepository;
use User\Services\Grpc\Id;
use User\Services\Grpc\WalletInfo;
use User\Services\Grpc\WalletRequest;
use User\Services\Grpc\WalletType;
use User\Support\UserActivityHelper;

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
        $wallet = $this->user_repository->getUserWallet($id, $crypto_name);
        $wallet_object = new WalletInfo();
        if (!$wallet)
            return $wallet_object;

        $wallet_object->setAddress($wallet->address);
        $wallet_object->setWalletType($walletRequest->getWalletType());

        return $wallet_object;
    }

    /**
     * @param SponsorUserRequest $request
     * @return array
     */
    public function createAndSponsorUser(SponsorUserRequest $request): array
    {
        $user_array = [];
        $user_array['first_name'] = $request->get('first_name');
        $user_array['last_name'] = $request->get('last_name');
        $user_array['email'] = $request->get('email');
        $user_array['username'] = $request->get('username');
        $user_array['birthday'] = $request->get('birthday');
        $user_array['sponsor_id'] = auth()->user()->id;
        $user_array['email_verified_at'] = now();
        $user_array['password'] = strtolower(Str::random(8));
        $user = User::query()->create($user_array);
        $user->assignRole(USER_ROLE_CLIENT);

        return [$user,$user_array['password']];
    }

}
