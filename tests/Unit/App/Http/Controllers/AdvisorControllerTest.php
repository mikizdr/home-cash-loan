<?php

namespace Tests\Unit\App\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class AdvisorControllerTest extends TestCase
{
    use RefreshDatabase;

    public User $advisor;

    public function setUp(): void
    {
        parent::setUp();

        // Create an advisor user and log them in
        $this->advisor = User::factory()->create(['role_id' => Role::ADVISOR]);
        $this->actingAs($this->advisor);
    }

    #[Test]
    public function index()
    {
        $numberOfClients = 15;
        // Create clients for the advisor
        Client::factory()->count($numberOfClients)->create(['advisor_id' => $this->advisor->id]);

        $perPage = 10;

        // Call the index method
        $response = $this->get(route('clients.index'));

        // Assert the response
        $response->assertStatus(200);
        $response->assertViewIs('client.index');
        $response->assertViewHas('clients');

        // Assert pagination
        $clients = $response->viewData('clients');
        $this->assertEquals($perPage, $clients->count());
        $this->assertEquals($numberOfClients, $clients->total());
    }

    #[Test]
    public function create()
    {
        // Call the create method
        $response = $this->get(route('clients.create'));

        // Assert the response
        $response->assertStatus(200);
        $response->assertViewIs('client.create');
    }
}
