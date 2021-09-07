<?php


namespace User\Services;


use Spatie\Permission\Models\Role;
use User\Repository\UserRepository;

class UserService
{
    private $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function userUpdate(User $user)
    {
        $user_updated = $this->user_repository->update($user);
    }

}
