<?php

namespace Tests\Feature\Chat;

use App\Events\MessageSent;
use App\Models\Admin;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(bool $active = true): Admin
    {
        return Admin::create([
            'name' => 'Admin Uji',
            'email' => 'admin.'.uniqid().'@example.com',
            'password' => 'rahasia-admin',
            'is_active' => $active,
        ]);
    }

    public function test_guest_cannot_send_a_chat_message(): void
    {
        $this->post('/kontak/chat/kirim', ['body' => 'Halo'])
            ->assertRedirect(route('login'));

        $this->assertDatabaseCount('messages', 0);
    }

    public function test_authenticated_user_can_send_a_message(): void
    {
        Event::fake([MessageSent::class]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/kontak/chat/kirim', [
            'body' => 'Halo, kue tersedia?',
        ]);

        $response->assertOk()
            ->assertJsonPath('message.body', 'Halo, kue tersedia?')
            ->assertJsonPath('message.sender_role', 'user');

        $this->assertDatabaseHas('conversations', [
            'user_id' => $user->id,
            'admin_unread_count' => 1,
        ]);

        $this->assertDatabaseHas('messages', [
            'body' => 'Halo, kue tersedia?',
            'sender_type' => User::class,
            'sender_id' => $user->id,
        ]);

        Event::assertDispatched(MessageSent::class);
    }

    public function test_reading_chat_clears_user_unread_count(): void
    {
        $user = User::factory()->create();
        $conversation = Conversation::forUser($user);
        $conversation->messages()->create([
            'body' => 'Pesananmu sedang disiapkan.',
            'sender_type' => Admin::class,
            'sender_id' => $this->makeAdmin()->id,
        ]);
        $conversation->recordMessage('admin');

        $this->assertSame(1, $conversation->fresh()->user_unread_count);

        $this->actingAs($user)->postJson('/kontak/chat/baca')->assertOk();

        $this->assertSame(0, $conversation->fresh()->user_unread_count);
    }

    public function test_contact_page_shows_chat_for_authenticated_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/kontak')
            ->assertOk()
            ->assertSee('chatWidget(', false)
            ->assertDontSee('Masuk untuk mulai chat');
    }

    public function test_contact_page_prompts_guests_to_login(): void
    {
        $this->get('/kontak')
            ->assertOk()
            ->assertSee('chat-guest')
            ->assertSee('Masuk ke akun Star Cake')
            ->assertDontSee('chatWidget(', false);
    }

    public function test_admin_chat_requires_admin_authentication(): void
    {
        $this->get('/admin/pesan')->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_reply_and_flag_message_for_customer(): void
    {
        Event::fake([MessageSent::class]);

        $user = User::factory()->create();
        $conversation = Conversation::forUser($user);
        $conversation->messages()->create([
            'body' => 'Halo admin',
            'sender_type' => User::class,
            'sender_id' => $user->id,
        ]);
        $conversation->recordMessage('user');

        $admin = $this->makeAdmin();

        $this->actingAs($admin, 'admin')->get('/admin/pesan')->assertOk();
        $this->actingAs($admin, 'admin')->get('/admin/pesan/'.$conversation->id)->assertOk();

        $this->assertSame(0, $conversation->fresh()->admin_unread_count);

        $this->actingAs($admin, 'admin')->postJson(
            '/admin/pesan/'.$conversation->id.'/kirim',
            ['body' => 'Halo, ada yang bisa dibantu?'],
        )->assertOk()->assertJsonPath('message.sender_role', 'admin');

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'body' => 'Halo, ada yang bisa dibantu?',
            'sender_type' => Admin::class,
            'sender_id' => $admin->id,
        ]);

        $this->assertSame(1, $conversation->fresh()->user_unread_count);
        $this->assertSame(0, $conversation->fresh()->admin_unread_count);
    }

    public function test_conversation_channel_authorisation_rules(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $conversation = Conversation::forUser($owner);

        $callback = Broadcast::driver()->getChannels()->get('conversation.{conversationId}');

        $this->assertNotNull($callback, 'The conversation channel is not registered.');

        $this->assertTrue((bool) $callback($owner, $conversation->id));
        $this->assertFalse((bool) $callback($intruder, $conversation->id));

        $this->assertTrue((bool) $callback($this->makeAdmin(), $conversation->id));
        $this->assertFalse((bool) $callback($this->makeAdmin(false), $conversation->id));
    }
}
