<?php

namespace Collejo\Foundation\Testing;

use Collejo\App\Modules\ACL\Contracts\UserRepository;

trait CreatesUsers
{
    /**
     * Creates an admin user.
     *
     * @return mixed
     */
    public function createAdminUser()
    {
        $admin = $this->userRepository->createAdminUser('test', 'test@test.com', '123');

        $permission = $this->userRepository->createPermissionIfNotExists('view_user_account_info');

        $role = $this->userRepository->getRoleByName('admin');

        $this->userRepository->addPermissionToRole($role, $permission);

        $this->userRepository->addRoleToUser($admin, $role);

        return $admin;
    }

    public function setup()
    {
        parent::setup();

        $this->userRepository = $this->app->make(UserRepository::class);
    }
}
