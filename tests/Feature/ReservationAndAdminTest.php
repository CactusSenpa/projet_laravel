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

    public function test_product_without_pack_can_be_reserved_with_correct_estimation_and_deposit(): void
    {
        $category = \App\Models\Category::query()->create([
            'name' => 'Batteries',
            'slug' => 'batteries',
        ]);

        $product = \App\Models\Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Batterie lithium 10 kWh 48 V',
            'reference' => 'BAT-L10',
            'daily_price' => 140,
            'deposit' => 1600,
            'quantity' => 4,
            'is_active' => true,
        ]);

        $start = now()->addDay()->toDateString();
        $end = now()->addDays(2)->toDateString(); // 2 days

        $response = $this->post(route('reservation.store'), [
            'product_id' => $product->id,
            'product_quantity' => 1,
            'customer_name' => 'Bacem',
            'customer_phone' => '53663608',
            'start_date' => $start,
            'end_date' => $end,
            'location' => 'Tunis',
        ]);

        $response->assertRedirect();

        $reservation = \App\Models\Reservation::query()->where('customer_name', 'Bacem')->first();
        $this->assertNotNull($reservation);
        $this->assertNull($reservation->pack_id);
        $this->assertEquals(280.00, (float) $reservation->estimated_price);
        $this->assertEquals(1600.00, (float) $reservation->deposit_amount);

        $this->assertDatabaseHas('reservation_products', [
            'reservation_id' => $reservation->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $follow = $this->get(route('reservation.success', $reservation));
        $follow->assertOk();
        $follow->assertSee('Batterie lithium 10 kWh 48 V');
        $follow->assertSee('280,00 TND');
        $follow->assertSee('1 600,00 TND');
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

    public function test_confirmed_reservation_disables_dates_and_rejects_overlapping_booking_when_stock_exhausted(): void
    {
        $category = \App\Models\Category::query()->create([
            'name' => 'Générateurs',
            'slug' => 'generateurs',
        ]);

        $product = \App\Models\Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Groupe électrogène 3 kVA',
            'reference' => 'GEN-3K',
            'daily_price' => 60,
            'deposit' => 500,
            'quantity' => 2, // Total stock: 2
            'is_active' => true,
        ]);

        $startDate = now()->addDays(5)->toDateString();
        $endDate = now()->addDays(6)->toDateString();

        // 1. Create first reservation for 2 units (full stock) and confirm it
        $firstReservation = \App\Models\Reservation::query()->create([
            'customer_name' => 'First Client',
            'customer_phone' => '20000000',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'location' => 'Tunis',
            'status' => 'confirmed',
            'estimated_price' => 240,
            'deposit_amount' => 1000,
        ]);

        $firstReservation->products()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        // 2. Query unavailable dates endpoint
        $apiResponse = $this->getJson(route('reservation.unavailable-dates', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]));

        $apiResponse->assertOk();
        $this->assertContains($startDate, $apiResponse->json('unavailable_dates'));
        $this->assertContains($endDate, $apiResponse->json('unavailable_dates'));

        // 3. Attempt a second booking for the same dates -> must be rejected
        $failedResponse = $this->from(route('reservation.create'))->post(route('reservation.store'), [
            'product_id' => $product->id,
            'product_quantity' => 1,
            'customer_name' => 'Second Client',
            'customer_phone' => '50000000',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'location' => 'Tunis',
        ]);

        $failedResponse->assertRedirect(route('reservation.create'));
        $failedResponse->assertSessionHasErrors('start_date');

        // 4. Booking for available dates (e.g. next month) must succeed
        $availableStart = now()->addDays(15)->toDateString();
        $availableEnd = now()->addDays(16)->toDateString();

        $successResponse = $this->post(route('reservation.store'), [
            'product_id' => $product->id,
            'product_quantity' => 1,
            'customer_name' => 'Second Client',
            'customer_phone' => '50000000',
            'start_date' => $availableStart,
            'end_date' => $availableEnd,
            'location' => 'Tunis',
        ]);

        $successResponse->assertRedirect();
        $this->assertDatabaseHas('reservations', [
            'customer_name' => 'Second Client',
            'status' => 'pending',
        ]);
    }
}
