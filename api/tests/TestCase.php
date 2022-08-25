<?php

namespace Tests;

use Faker\Factory;
use Faker\Generator as Faker;
use Faker\Provider\pt_BR\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected Faker $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->faker->addProvider(new Person($this->faker));
    }
}
