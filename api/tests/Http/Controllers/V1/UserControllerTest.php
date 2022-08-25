<?php

namespace Tests\Http\Controllers\V1;

use App\Enums\UserTypeEnum;
use App\Http\Middleware\Authenticate;
use App\Models\User;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\UserService;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(Authenticate::class);
    }

    /**
     * @test
     */
    public function shouldCreateUser()
    {
        $user = [
            'name'                  => fake()->name,
            'cpf_cnpj'              => fake('pt_BR')->cpf(),
            'email'                 => fake()->email(),
            'password'              => 'secret',
            'password_confirmation' => 'secret',
            'type'                  => UserTypeEnum::COMMON->value
        ];

        $this->post('v1/users', ['user' => $user])->assertSuccessful();
    }

    /**
     * @test
     */
    public function shouldCreateUserShopkeeper()
    {
        $user = [
            'name'                  => fake()->name,
            'cpf_cnpj'              => fake('pt_BR')->cpf(),
            'email'                 => fake()->email(),
            'password'              => 'secret',
            'password_confirmation' => 'secret',
            'type'                  => UserTypeEnum::SHOPKEEPER->value
        ];

        $this->post('v1/users', ['user' => $user])->assertSuccessful();
    }

    /**
     * @test
     */
    public function shouldNotCreateUserMissingData()
    {
        $user = [
            'name'                  => fake()->name,
            'cpf_cnpj'              => fake('pt_BR')->cpf(),
            'email'                 => fake()->email(),
            'password'              => 'secret',
            'password_confirmation' => 'secret',
        ];

        $this->post('v1/users', ['user' => $user])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function shouldFindUsers()
    {
        $this->actingAs(User::factory()->create());

        $this->get('v1/users')->assertSuccessful();
    }

    /**
     * @test
     */
    public function shouldThrowQueryException()
    {
        $user = [
            'name'                  => fake()->name,
            'cpf_cnpj'              => fake('pt_BR')->cpf(),
            'email'                 => fake()->email(),
            'password'              => 'secret',
            'password_confirmation' => 'secret',
            'type'                  => UserTypeEnum::COMMON->value
        ];

        $userService = \Mockery::mock(UserService::class);
        $this->app->instance(UserServiceInterface::class, $userService);
        $userService->shouldReceive('create')->once()->andThrowExceptions([new QueryException('', [], new \Exception())]);

        $this->post('v1/users', ['user' => $user])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
