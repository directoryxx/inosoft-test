<?php

namespace Tests\Traits;

use Illuminate\Foundation\Testing\WithFaker;

trait SetupTest
{
    use WithFaker;

    public $logged;

    public function createUser()
    {
        $data = [
            'name' => 'Angga',
            'email' => $this->faker()->email(),
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $test = $this
            ->postJson('/api/v1/auth/register', $data)
            ->assertStatus(201)
            ->decodeResponseJson();
        $this->assertEquals($data['name'], $test['data']['name']);

        $this->logged = $test;
    }

    public function createVehicle()
    {
        /**
         * Create Vehicle with car
         */
        $data = [
            'year' => 1000,
            'color' => 'blue',
            'price' => 1000,
            'stock' => 100,
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

        return $car;
    }
}