<?php

namespace Tests\Repositories;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Collection;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{

    private UserRepository $repository;

    /**
     * @test
     */
    public function shouldCreateUser()
    {
        $attributes = User::factory()->make()->toArray();

        $user = $this->repository->createUser($attributes);

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @test
     */
    public function shouldFindUserByUuid()
    {
        $user = User::factory()->create();

        $result = $this->repository->findUserBy('uuid', $user->uuid);

        $this->assertEquals($user->id, $result->id);
    }

    /**
     * @test
     */
    public function shouldNotFoundUserByUuid()
    {
        $result = $this->repository->findUserBy('uuid', fake()->uuid());

        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function shouldFindUsers()
    {
        User::factory()->create();

        $result = $this->repository->findUsers()->get();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new UserRepository();
    }
}
