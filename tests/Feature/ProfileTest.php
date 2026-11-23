<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/profil')
            ->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profil')
            ->patch('/profil', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '08123456789',
                'address' => 'Jl. Contoh No. 1',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profil');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertSame('08123456789', $user->phone);
        $this->assertSame('Jl. Contoh No. 1', $user->address);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profil')
            ->patch('/profil', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profil');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_changing_password_requires_the_current_password(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from('/profil')
            ->patch('/profil', [
                'name' => $user->name,
                'email' => $user->email,
                'current_password' => 'password-yang-salah',
                'password' => 'password-baru',
                'password_confirmation' => 'password-baru',
            ])
            ->assertSessionHasErrors('current_password')
            ->assertRedirect('/profil');
    }
}
