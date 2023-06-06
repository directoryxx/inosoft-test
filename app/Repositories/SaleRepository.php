<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Sale;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Eloquent\Builder;

class SaleRepository
{
    protected $sales;

    protected $vehicle;

    public function __construct(Sale $sale, Vehicle $vehicle)
    {
        $this->sales = $sale;
        $this->vehicle = $vehicle;
    }

    public function filter(array $filter) : Builder
    {
        return $this->sales
        ->when(has_key('vehicle_type', $filter), function ($query) use ($filter) {
            return $query->whereHas('vehicle', function($query) use ($filter) {
                return $query->where('vehicle_type', $filter['vehicle_type']);
            });
        });
    }


    public function create(array $sales) : Sale
    {
        $sales = $this->sales->create($sales);

        $vehicle = $this->vehicle->where('_id', $sales['vehicle_id'])->first();

        $vehicle->update([
            'stock' => $vehicle->stock - $sales['quantity']
        ]);

        return $sales;
    }
}