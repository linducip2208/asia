<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_portal_login_page_renders(): void
    {
        $response = $this->get('/portal/login');
        $response->assertStatus(200);
    }

    public function test_portal_register_page_renders(): void
    {
        $response = $this->get('/portal/register');
        $response->assertStatus(200);
    }

    public function test_customer_can_login(): void
    {
        $customer = Customer::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $this->get('/portal/login'); // get CSRF cookie

        $response = $this->post('/portal/login', [
            'email' => $customer->email,
            'password' => 'password',
            '_token' => csrf_token(),
        ]);

        $response->assertRedirect('/portal');
        $this->assertAuthenticated('customer');
    }

    public function test_customer_can_logout(): void
    {
        $customer = Customer::factory()->create(['password' => bcrypt('password')]);

        $this->actingAs($customer, 'customer')
            ->get('/portal'); // establish session

        $response = $this->post('/portal/logout', ['_token' => csrf_token()]);

        $response->assertRedirect('/portal/login');
        $this->assertGuest('customer');
    }

    public function test_customer_can_see_their_orders(): void
    {
        $customer = Customer::factory()->create(['password' => bcrypt('password')]);
        $outlet = Outlet::factory()->create();
        $user = User::factory()->create();

        Order::factory()->create([
            'customer_id' => $customer->id,
            'outlet_id' => $outlet->id,
            'user_id' => $user->id,
            'order_number' => 'INV-TEST-001',
            'order_status' => 'completed',
        ]);

        $response = $this->actingAs($customer, 'customer')->get('/portal');

        $response->assertStatus(200);
        $response->assertSee('INV-TEST-001');
    }

    public function test_customer_cannot_see_other_customer_orders(): void
    {
        $customer1 = Customer::factory()->create(['password' => bcrypt('password')]);
        $customer2 = Customer::factory()->create(['password' => bcrypt('password')]);
        $outlet = Outlet::factory()->create();
        $user = User::factory()->create();

        $order = Order::factory()->create([
            'customer_id' => $customer2->id,
            'outlet_id' => $outlet->id,
            'user_id' => $user->id,
            'order_number' => 'INV-OTHER-001',
        ]);

        $response = $this->actingAs($customer1, 'customer')->get("/portal/order/{$order->id}");

        $response->assertStatus(404);
    }
}
