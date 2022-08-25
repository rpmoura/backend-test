<?php

namespace Tests\Http\Middleware;

use App\Http\Middleware\CanAbilities;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tests\TestCase;

class CanAbilitiesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldUnauthorized()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $request = new Request();
        $request->setUserResolver(function() use ($user) {
            return $user;
        });

        $middleware = new CanAbilities();

        $ability = 'can-transfer';

        $closure = function () {
        };

        $this->expectException(UnauthorizedHttpException::class);

        $middleware->handle($request, $closure, $ability);
    }

    /**
     * @test
     */
    public function shouldAuthorized()
    {
        $user = User::factory()->create();

        $ability = "can-transfer";

        $token = $user->createToken('auth_token', [$ability]);
        $user->withAccessToken($token->accessToken);

        $this->actingAs($user);

        $request = new Request();

        $request->setUserResolver(function() use ($user) {
            return $user;
        });

        $middleware = new CanAbilities();

        $closure = function () {
        };

        $response = $middleware->handle($request, $closure, $ability);
        $this->assertEquals(null, $response);
    }

    /**
     * @test
     */
    public function shouldUnauthorizedOtherAbility()
    {
        $user = User::factory()->create();

        $ability = 'can-transfer';

        $token = $user->createToken('auth_token', [$ability]);
        $user->withAccessToken($token->accessToken);

        $this->actingAs($user);

        $request = new Request();

        $request->setUserResolver(function() use ($user) {
            return $user;
        });

        $middleware = new CanAbilities();

        $closure = function () {
        };

        $routeAbility = 'can-other';

        $this->expectException(UnauthorizedHttpException::class);

        $middleware->handle($request, $closure, $routeAbility);
    }
}
