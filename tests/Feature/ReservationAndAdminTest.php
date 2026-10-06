<?php

namespace Tests\Feature;

use App\Models\Pack;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationAndAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_end_date_cannot_be_before_start_date(): void
    {
        $response = $this->from(route('reservation.create'))->post(route('reservation.store'), [
            'customer_name' => 'Ali',
            'customer_phone' => '20123456',
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'location' => 'Tunis',
        ]);

        $response->assertSessionHasErrors('end_date');
        $this->assertDatabaseCount('reservations', 0);
    }

    public function test_valid_reservation_is_stored_as_pending(): void
    {
        $pack = Pack::query()->create([
            'name' => 'Pack Test',
            'price_per_day' => 100,
            'deposit' => 400,
            'energy_capacity_wh' => 5000,
            'continuous_power_w' => 2000,
            'is_active' => true,
        ]);

        $this->post(route('reservation.store'), [
            'pack_id' => $pack->id,
            'customer_name' => 'Ali',
            'customer_phone' => '20123456',
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'location' => 'Tunis',
        ])->assertRedirect();

        $this->assertDatabaseHas('reservations', [
            'customer_name' => 'Ali',
            'status' => 'pending',
            'estimated_price' => 200,
        ]);
    }

    public function test_guest_cannot_access_admin(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_non_admin_is_forbidden(): void
    {
        $user = User::query()->create([
            'name' => 'Client',
            'email' => 'client@test.com',
            'password' => 'password',
            'role' => 'customer',
            'is_active' => true,
        ]);

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_admin_can_open_dashboard(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => 'password',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
    }
}
