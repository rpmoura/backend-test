<?php

namespace Tests\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $repository    = new UserRepository();
        $this->service = new UserService($repository);
    }

    /**
     * @test
     */
    public function shouldCreateUser()
    {
        $attributes = User::factory()->make()->toArray();

        $result = $this->service->create($attributes);
        $this->assertInstanceOf(User::class, $result);
    }

    /**
     * @test
     */
    public function shouldFindUsers()
    {
        User::factory(2)->create();

        $result = $this->service->findUsers();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertCount(2, $result);
    }

    /**
     * @test
     */
    public function shouldFindUser()
    {
        $user   = User::factory()->create();
        $result = $this->service->findUserByUuid($user->uuid);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($user->email, $result->email);
    }

    /**
     * @test
     */
    public function shouldNotFindUser()
    {
        User::factory()->create();

        $this->expectException(NotFoundHttpException::class);

        $this->service->findUserByUuid(fake()->uuid());
    }
}
