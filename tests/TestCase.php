<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Holds the user role.
     * @var Role
     */
    public Role $userRole;

    /**
     * Holds the advisor role.
     * @var Role
     */
    public Role $advisorRole;

    /**
     * Holds the user.
     * @var User
     */
    public User $user;

    /**
     * Holds the advisor.
     * @var User
     */
    public User $advisor;

    /**
     * Set up the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create a user role before each test
        $this->userRole = Role::factory()->create([
            'name' => 'user',
        ]);

        // Create an advisor role before each test
        $this->advisorRole = Role::factory()->create([
            'name' => 'advisor',
        ]);

        // Create a user before each test
        $this->user = User::factory()->unverified()->create([
            'role_id' => $this->userRole->id,
        ]);

        // Create an advisor before each test
        $this->user = User::factory()->unverified()->create([
            'role_id' => $this->userRole->id,
        ]);
    }
}
