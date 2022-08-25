<?php

namespace Tests\Http\Controllers\V1\Auth;

use App\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function credentials(): array
    {
        $user = User::factory()->create();
        info($user->toArray());
        $credentials = [
            'credential' => $user->email,
            'password'   => 'secret'
        ];

        $this->assertNotEmpty($credentials);;

        return $credentials;
    }

    /**
     * @test
     */
    public function shouldSignInSuccessfully()
    {
        $user = User::factory()->create();

        $credentials = [
            'credential' => $user->email,
            'password'   => 'secret'
        ];

        $this->post('/v1/auth/sign-in', $credentials)->assertSuccessful();
    }

    /**
     * @test
     */
    public function shouldLoginUnsuccessfully()
    {
        $user = User::factory()->create();

        $credentials = [
            'credential' => $user->email,
            'password'   => 'invalid'
        ];

        $this->post('/v1/auth/sign-in', $credentials)->assertUnauthorized();
    }
}
