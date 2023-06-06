<?php

namespace App\Models;


class Motorcycle extends Vehicle
{
    protected $fillable = [
        'machine',
        'suspension_type',
        'transmission_type'
    ];
}
