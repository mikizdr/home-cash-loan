<?php

namespace Tests\Unit\App\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;

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

    #[Test]
    public function store(): void
    {
        // Prepare the data for the new client
        $clientData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
            'advisor_id' => $this->advisor->id,
        ];

        // Call the store method
        $response = $this->actingAs($this->advisor)
            ->post(route('clients.store'), $clientData);

        // Assert the response
        $response->assertStatus(302); // Redirect status
        $response->assertRedirect(route('clients.index'));
        $response->assertSessionHas('client-action', 'Client John Doe created successfully!');

        // Assert the client was created
        $this->assertDatabaseHas('clients', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
            'advisor_id' => $this->advisor->id,
        ]);
    }

    /**
     * Data provider for test_cant_store_client_without_required_fields.
     *
     * @return array
     */
    public static function requiredFieldsProvider(): array
    {
        return [
            'missing_first_name' => [['first_name' => '']],
            'missing_last_name' => [['last_name' => '']],
            'missing_email_and_phone' => [['email' => '', 'phone' => '']],
        ];
    }

    /**
     * Test that a client cannot be stored without required fields.
     */
    #[DataProvider('requiredFieldsProvider')]
    #[Test]
    public function cant_store_client_without_required_fields(array $missingField): void
    {
        // Prepare the data for the new client
        $clientData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
            'advisor_id' => $this->advisor->id,
        ];

        // Remove the missing field from the data
        $clientData = array_merge($clientData, $missingField);

        // Call the store method
        $response = $this->actingAs($this->advisor)
            ->post(route('clients.store'), $clientData);

        // Assert the response
        $response->assertStatus(302); // Redirect status
        $response->assertSessionHasErrors(array_keys($missingField));

        // Assert the client was not created
        $this->assertDatabaseMissing('clients', [
            'email' => $clientData['email'],
        ]);
    }

    /**
     * Data provider for test_cant_store_client_without_required_fields.
     *
     * @return array
     */
    public static function emailOrPhone(): array
    {
        return [
            'missing_email' => [
                [
                    'email' => '',
                    'phone' => '12345789',
                ]
            ],
            'missing_phone' => [
                [
                    'email' => 'email@test.com',
                    'phone' => '',
                ]
            ],
        ];
    }

    #[DataProvider('emailOrPhone')]
    #[Test]
    public function client_will_be_created_with_at_least_email_or_phone(array $emailOrPhone): void
    {
        // Prepare the data for the new client
        $clientData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => '',
            'phone' => '',
            'address' => '123 Main St',
            'advisor_id' => $this->advisor->id,
        ];

        // Remove the missing field from the data
        $clientData = array_merge($clientData, $emailOrPhone);

        // Call the store method
        $response = $this->actingAs($this->advisor)
            ->post(route('clients.store'), $clientData);

        // Assert the response
        $response->assertStatus(302); // Redirect status
        $response->assertSessionDoesntHaveErrors(['email', 'phone']);

        // Assert the client was created
        $this->assertDatabaseHas('clients', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => !empty($emailOrPhone['email']) ? $emailOrPhone['email'] : '',
            'phone' => !empty($emailOrPhone['phone']) ? $emailOrPhone['phone'] : null,
            'address' => '123 Main St',
            'advisor_id' => $this->advisor->id,
        ]);
    }

    #[Test]
    public function client_wont_be_created_without_at_least_email_or_phone(): void
    {
        // Prepare the data for the new client
        $clientData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => '',
            'phone' => '',
            'address' => '123 Main St',
            'advisor_id' => $this->advisor->id,
        ];

        // Call the store method
        $response = $this->actingAs($this->advisor)
            ->post(route('clients.store'), $clientData);

        // Assert the response
        $response->assertStatus(302); // Redirect status
        $response->assertSessionHasErrors(['email', 'phone']);

        // Assert the client was not created
        $this->assertDatabaseMissing('clients', [
            'email' => $clientData['email'],
        ]);
    }
}
