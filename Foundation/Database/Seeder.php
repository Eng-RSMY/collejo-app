<?php

namespace Collejo\Foundation\Database;

use Collejo\Foundation\Database\Eloquent\LoadFactories;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder as BaseSeeder;
use Uuid;

abstract class Seeder extends BaseSeeder
{

    use LoadFactories;

    public function __construct()
    {
        $this->loadFactories();
    }

    public function createPivotIds($collection)
    {
        if (!$collection instanceOf Collection) {
            $collection = collect($collection);
        }

        $ids = $collection->map(function () {
            return ['id' => (string)Uuid::generate(4)];
        });

        return array_combine(array_values($collection->toArray()), $ids->all());
    }
}