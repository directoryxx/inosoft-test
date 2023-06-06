<?php

namespace App\Models;

class Car extends Vehicle
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'machine',
        'passenger_capacity',
        'type',
    ];
}
