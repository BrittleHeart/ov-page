<?php

namespace App\Traits;

use Faker\Factory;

trait WithFaker
{
    private function getFaker(): \Faker\Generator
    {
        $faker = Factory::create('pl_PL');

        return $faker;
    }
}
