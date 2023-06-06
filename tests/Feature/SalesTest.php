<?php

namespace Tests\Feature;

use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class SalesTest extends TestCase
{
    use SetupTest;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->createUser();

        $car = $this->createVehicle();


        /**
         * Proper order
         */
        $data = [
            'vehicle_id' => $car['data']['_id'],
            'quantity' => 1
        ];

        $order = $this
            ->withHeader("Authorization", "Bearer ".$this->logged['data']['token'])
            ->postJson('/api/v1/sales', $data)
            ->assertStatus(201)
            ->decodeResponseJson();
        $this->assertEquals($data['quantity'], $order['data']['quantity']);
        $this->assertEquals($data['vehicle_id'], $order['data']['vehicle_id']);

        /**
         * Check Vehicle decreased
         */
        $vehicleModel = Vehicle::where('_id', $data['vehicle_id'])->first();
        $this->assertEquals(100 - $data['quantity'] , $vehicleModel->stock);

        /**
         * Wrong order (not found vehicle)
         */
        $data = [
            'vehicle_id' => "1",
            'quantity' => 1
        ];

        $order = $this
            ->withHeader("Authorization", "Bearer ".$this->logged['data']['token'])
            ->postJson('/api/v1/sales', $data)
            ->assertStatus(422);

        /**
         * Wrong order (Beyond stock available)
         */
        $data = [
            'vehicle_id' => $car['data']['_id'],
            'quantity' => 100
        ];

        $order = $this
            ->withHeader("Authorization", "Bearer ".$this->logged['data']['token'])
            ->postJson('/api/v1/sales', $data)
            ->assertStatus(422);

        /**
         * Check Report
         */
        $order = $this
            ->withHeader("Authorization", "Bearer ".$this->logged['data']['token'])
            ->getJson('/api/v1/sales/report')
            ->assertStatus(200)
            ->decodeResponseJson();
            
        $this->assertEquals(1, $order['total_quantity_sold']);
        $this->assertEquals($vehicleModel->price, $order['total_revenue']);
        $this->assertEquals(1, count($order['data']));

        /**
         * Check report motorcycle
         */
        $order = $this
            ->withHeader("Authorization", "Bearer ".$this->logged['data']['token'])
            ->getJson('/api/v1/sales/report?vehicle_type=motorcycle')
            ->assertStatus(200)
            ->decodeResponseJson();
        $this->assertEquals(0, count($order['data']));
    }
}
