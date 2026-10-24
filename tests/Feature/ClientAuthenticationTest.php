<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Tests\TestCase;

class ClientAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_register_and_access_profile(): void
    {
        NotificationFacade::fake();

        $this->post(route('register'), [
            'name' => 'Client Test',
            'email' => 'client@example.com',
            'phone' => '20123456',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('verification.notice'));

        $this->assertAuthenticatedAs(User::query()->where('email', 'client@example.com')->first());
        $client = User::query()->where('email', 'client@example.com')->first();
        NotificationFacade::assertSentTo($client, VerifyEmail::class);
        $this->get(route('client.profile'))->assertRedirect(route('verification.notice'));
    }

    public function test_client_can_update_profile_photo(): void
    {
        Storage::fake('public');
        $client = User::factory()->create(['role' => 'customer', 'is_active' => true]);

        $this->actingAs($client)->put(route('client.profile.update'), [
            'name' => 'Updated Client',
            'email' => $client->email,
            'phone' => '20999999',
            'profile_photo' => UploadedFile::fake()->image('profile.jpg'),
        ])->assertRedirect();

        $client->refresh();
        $this->assertSame('Updated Client', $client->name);
        Storage::disk('public')->assertExists($client->profile_photo);
    }

    public function test_client_history_is_scoped_to_authenticated_client(): void
    {
        $client = User::factory()->create(['role' => 'customer', 'is_active' => true]);
        $other = User::factory()->create(['role' => 'customer', 'is_active' => true]);
        foreach ([$client, $other] as $user) {
            Reservation::query()->create([
                'user_id' => $user->id,
                'customer_name' => $user->name,
                'customer_phone' => '20123456',
                'start_date' => now()->addDay(),
                'end_date' => now()->addDays(2),
                'location' => 'Tunis',
            ]);
        }

        $this->actingAs($client)->get(route('client.reservations'))
            ->assertOk()
            ->assertSee('Réservation #'.Reservation::query()->where('user_id', $client->id)->first()->id)
            ->assertDontSee('Réservation #'.Reservation::query()->where('user_id', $other->id)->first()->id);
    }

    public function test_sanctum_client_token_can_read_only_client_reservations(): void
    {
        $client = User::factory()->create(['role' => 'customer', 'is_active' => true]);
        $token = $client->createToken('test')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/reservations')
            ->assertOk();
    }

    public function test_sanctum_admin_token_can_read_admin_reservations(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $adminToken = $admin->createToken('test')->plainTextToken;
        $this->withHeader('Authorization', 'Bearer '.$adminToken)
            ->getJson('/api/admin/reservations')
            ->assertOk();
    }

    public function test_admin_can_create_update_and_delete_clients(): void
    {
        NotificationFacade::fake();
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);

        $this->actingAs($admin)->post(route('admin.clients.store'), [
            'name' => 'Managed Client',
            'email' => 'managed@example.com',
            'phone' => '20111111',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('admin.clients.index'));

        $client = User::query()->where('email', 'managed@example.com')->firstOrFail();
        NotificationFacade::assertSentTo($client, VerifyEmail::class);
        $this->actingAs($admin)->put(route('admin.clients.update', $client), [
            'name' => 'Updated Managed Client',
            'email' => $client->email,
            'phone' => '20222222',
            'is_active' => '1',
        ])->assertRedirect(route('admin.clients.index'));

        $this->actingAs($admin)->delete(route('admin.clients.destroy', $client))
            ->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $client->id]);
    }

    public function test_changing_client_email_requires_new_verification(): void
    {
        NotificationFacade::fake();
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $client = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $this->actingAs($admin)->put(route('admin.clients.update', $client), [
            'name' => $client->name,
            'email' => 'changed@example.com',
            'phone' => $client->phone,
            'is_active' => '1',
        ])->assertRedirect(route('admin.clients.index'));

        $client->refresh();
        $this->assertNull($client->email_verified_at);
        NotificationFacade::assertSentTo($client, VerifyEmail::class);
    }

    public function test_client_reservation_numbers_start_at_one_for_each_client(): void
    {
        $client = User::factory()->create(['role' => 'customer', 'is_active' => true]);
        foreach (['First', 'Second'] as $name) {
            Reservation::query()->create([
                'user_id' => $client->id,
                'customer_name' => $name,
                'customer_phone' => '20123456',
                'start_date' => now()->addDay(),
                'end_date' => now()->addDays(2),
                'location' => 'Tunis',
            ]);
        }

        $this->actingAs($client)->get(route('client.reservations'))
            ->assertSee('Réservation #1')
            ->assertSee('Réservation #2');
    }

    public function test_user_can_request_and_complete_password_reset(): void
    {
        NotificationFacade::fake();
        $client = User::factory()->create(['role' => 'customer', 'is_active' => true]);

        $this->post(route('password.email'), ['email' => $client->email])
            ->assertRedirect()
            ->assertSessionHas('status');

        NotificationFacade::assertSentTo($client, ResetPassword::class);
        $token = Password::broker()->createToken($client);

        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $client->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])->assertRedirect(route('login'));

        $this->assertTrue(Hash::check('new-password', $client->refresh()->password));
    }
}
