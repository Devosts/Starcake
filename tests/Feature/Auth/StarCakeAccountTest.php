<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StarCakeAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_email_and_password(): void
    {
        $response = $this->post('/register', [
            'name' => 'Siti Nurbaya',
            'email' => 'siti.nurbaya@example.com',
            'password' => 'password-baru',
            'password_confirmation' => 'password-baru',
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticated();

        $user = User::where('email', 'siti.nurbaya@example.com')->first();
        $this->assertNotNull($user);
        $this->assertNull($user->provider);
        $this->assertTrue(Hash::check('password-baru', $user->password));
    }

    public function test_user_can_login_with_email_and_password(): void
    {
        $user = User::factory()->create([
            'email' => 'masuk@example.com',
            'password' => Hash::make('rahasia-ku'),
        ]);

        $this->post('/login', [
            'email' => 'masuk@example.com',
            'password' => 'rahasia-ku',
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticatedAs($user);
    }

    public function test_profile_update_without_password_does_not_require_current_password(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->patch('/profil', ['name' => 'Nama Baru', 'email' => $user->email])
            ->assertSessionHasNoErrors();

        $this->assertSame('Nama Baru', $user->fresh()->name);
    }
}
