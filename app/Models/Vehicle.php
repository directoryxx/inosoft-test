<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $collection = 'vehicles';

    protected $guarded = ['_id'];

    public function motorcycle()
    {
        return $this->embedsOne(Motorcycle::class);
    }

    public function car()
    {
        return $this->embedsOne(Car::class);
    }
}
