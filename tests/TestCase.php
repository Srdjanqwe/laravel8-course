<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function user()
    {
        // return factory(User::class)->create(); // ovakav factory u L8 ne radi
        return User::factory()->create();
    }
}
