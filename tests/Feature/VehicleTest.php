<?php

namespace Tests\Feature;

use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class VehicleTest extends TestCase
{
    use SetupTest;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        Vehicle::truncate();
        
        $this->createUser();

        /**
         * Unauthorized
         */
        $test = $this
            ->getJson('/api/v1/vehicles')
            ->assertStatus(401);

        /**
         * Check access
         */
        $test = $this
            ->withHeader("Authorization", "Bearer ".$this->logged['data']['token'])
            ->getJson('/api/v1/vehicles')
            ->assertStatus(200)
            ->decodeResponseJson();
        $this->assertEquals(0, count($test['data']));


        /**
         * Create Vehicle with motorcycle
         */
        $dataMotorcycle = [
            'year' => 1000,
            'color' => 'blue',
            'price' => 1000,
            'stock' => 10,
            "vehicle_type" => 'motorcycle',
            'motorcycle' => [
                'machine' => 'Harley',
                'suspension_type' => 'Test',
                'transmission_type' => 'Manual'
            ]
        ];

        $motorcycle = $this
            ->withHeader("Authorization", "Bearer ".$this->logged['data']['token'])
            ->postJson('/api/v1/vehicles', $dataMotorcycle)
            ->assertStatus(201)
            ->decodeResponseJson();
        $this->assertEquals($dataMotorcycle['year'], $motorcycle['data']['year']);

        /**
         * Create Vehicle with car
         */
        $data = [
            'year' => 1000,
            'color' => 'blue',
            'price' => 1000,
            'stock' => 10,
            "vehicle_type" => 'car',
            'car' => [
                'machine' => 'Harley',
                'passanger_capacity' => 10,
                'type' => 'Manual'
            ]
        ];

        $car = $this
            ->withHeader("Authorization", "Bearer ".$this->logged['data']['token'])
            ->postJson('/api/v1/vehicles', $data)
            ->assertStatus(201)
            ->decodeResponseJson();
        $this->assertEquals($data['year'], $car['data']['year']);


        /**
         * Detail vehicle
         */
        $test = $this
            ->withHeader("Authorization", "Bearer ".$this->logged['data']['token'])
            ->getJson('/api/v1/vehicles/'.$motorcycle['data']['_id'])
            ->assertStatus(200)
            ->decodeResponseJson();
        $this->assertEquals($data['year'], $test['data']['year']);

        /**
         * Update vehicle
         */
        $dataMotorcycle['year'] = 10000;
        $test = $this
            ->withHeader("Authorization", "Bearer ".$this->logged['data']['token'])
            ->putJson('/api/v1/vehicles/'.$motorcycle['data']['_id'], $dataMotorcycle)
            ->assertStatus(200)
            ->decodeResponseJson();
        $this->assertEquals($dataMotorcycle['year'], $test['data']['year']);

        /**
         * Delete Vehicle
         */
        $test = $this
            ->withHeader("Authorization", "Bearer ".$this->logged['data']['token'])
            ->deleteJson('/api/v1/vehicles/'.$test['data']['_id'])
            ->assertStatus(200)
            ->decodeResponseJson();
        $this->assertTrue($test['success']);

        /**
         * Create Vehicle with car
         */
        $data = [
            'year' => 1000,
            'color' => 'blue',
            'price' => 1000,
            'stock' => 10,
            "vehicle_type" => 'car',
            'car' => [
                'machine' => 'Harley',
                'passanger_capacity' => 4,
                'type' => 'Manual'
            ]
        ];

        $car = $this
            ->withHeader("Authorization", "Bearer ".$this->logged['data']['token'])
            ->postJson('/api/v1/vehicles', $data)
            ->assertStatus(201)
            ->decodeResponseJson();
        $this->assertEquals($data['year'], $car['data']['year']);

        $data['year'] = 10000;
        $test = $this
            ->withHeader("Authorization", "Bearer ".$this->logged['data']['token'])
            ->putJson('/api/v1/vehicles/'.$car['data']['_id'], $data)
            ->assertStatus(200)
            ->decodeResponseJson();
        $this->assertEquals($data['year'], $test['data']['year']);
    }
}
