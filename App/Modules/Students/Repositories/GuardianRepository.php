<?php

namespace Collejo\App\Modules\Students\Repositories;

use Collejo\App\Modules\ACL\Contracts\UserRepository;
use Collejo\App\Modules\Students\Contracts\GuardianRepository as GuardianRepositoryContract;
use Collejo\Foundation\Repository\BaseRepository;
use DB;

class GuardianRepository extends BaseRepository implements GuardianRepositoryContract
{

    public function getGuardians($criteria)
    {
        return $this->search($criteria);
    }

    public function boot()
    {
        parent::boot();

        $this->userRepository = app()->make(UserRepository::class);
    }
}
