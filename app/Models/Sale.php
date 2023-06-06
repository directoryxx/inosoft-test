<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $collection = 'sales';

    protected $guarded = ['_id'];

    protected $fillable = [
        'vehicle_id',
        'quantity',
        'total_payment'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

}
