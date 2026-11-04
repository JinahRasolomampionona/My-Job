<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_opens_the_login_modal(): void
    {
        $response = $this->get('/login');

        $response->assertRedirect(route('index'));
        $response->assertSessionHas('openModal', 'loginname');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->candidat()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('candidates.candidate'));
    }

    public function test_ajax_login_returns_the_redirect_url_of_the_role(): void
    {
        $user = User::factory()->recruteur()->create();

        $response = $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertOk()->assertJsonPath('redirect', route('recruiters.recruiter'));
    }

    public function test_ajax_login_with_unknown_email_returns_an_error(): void
    {
        $this->postJson('/login', [
            'email' => 'inconnu@example.com',
            'password' => 'password',
        ])->assertStatus(422)->assertJsonValidationErrors('email');

        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
