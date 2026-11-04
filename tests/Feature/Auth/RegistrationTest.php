<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Notifications\BienvenueNotification;
use App\Notifications\NouvelInscritNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        foreach (['admin', 'recruteur', 'candidat'] as $role) {
            Role::findOrCreate($role, 'web');
        }
    }

    public function test_registration_screen_opens_the_register_modal(): void
    {
        $response = $this->get('/register');

        $response->assertRedirect(route('index'));
        $response->assertSessionHas('openModal', 'registername');
    }

    public function test_new_users_can_register_with_ajax(): void
    {
        Notification::fake();
        $admin = User::factory()->admin()->create();

        $response = $this->postJson('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'candidat',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertCreated()->assertJsonPath('email', 'test@example.com');
        $this->assertGuest();

        $user = User::where('email', 'test@example.com')->first();
        $this->assertTrue($user->hasRole('candidat'));
        Notification::assertSentTo($user, BienvenueNotification::class);
        Notification::assertSentTo($admin, NouvelInscritNotification::class);
    }

    public function test_classic_registration_redirects_to_login_modal(): void
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'recruteur',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('index'));
        $response->assertSessionHas('openModal', 'loginname');
    }

    public function test_nobody_can_register_as_admin(): void
    {
        $response = $this->postJson('/register', [
            'name' => 'Pirate',
            'email' => 'pirate@example.com',
            'role' => 'admin',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors('role');
        $this->assertDatabaseMissing('users', ['email' => 'pirate@example.com']);
    }

    public function test_registration_validation_errors_are_returned_as_json(): void
    {
        $response = $this->postJson('/register', [
            'name' => '',
            'email' => 'pas-un-email',
            'role' => 'candidat',
            'password' => 'court',
            'password_confirmation' => 'autre',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'email', 'password']);
    }
}
