<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Car;
use App\Models\Motorcycle;
use App\Models\Vehicle;
use Jenssegers\Mongodb\Eloquent\Builder;

class VehicleRepository
{
    protected $vehicle;

    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function filter(array $filter) : Builder
    {
        return $this->vehicle
        ->when(has_key('id', $filter), function ($query) use ($filter) {
            return $query->where('_id', $filter['id']);
        });
    }

    public function create(array $vehicle) : Vehicle
    {
        $vehicleType = $vehicle['vehicle_type'];
        $car = $vehicle['car'] ?? null;
        $motorCycle = $vehicle['motorcycle'] ?? null;

        unset($vehicle['motorcycle']);
        unset($vehicle['car']);

        $vehicle = $this->vehicle->create($vehicle);

        if ($vehicleType == "motorcycle"){
            $vehicle->motorcycle()->save(new Motorcycle($motorCycle));
        } else if ($vehicleType == "car") {
            $vehicle->car()->save(new Car($car));
        }

        return $vehicle;
    }

    public function update(Vehicle $vehicle, array $update) : Vehicle
    {
        $vehicleType = $update['vehicle_type'];
        $car = $update['car'] ?? null;
        $motorCycle = $update['motorcycle'] ?? null;

        unset($update['vehicle_type']);
        unset($update['vehicle_type']);
        unset($update['motorcycle']);
        unset($update['car']);

        $this->filter(['id' => $vehicle->id])->update($update);

        $vehicle->refresh();

        if ($vehicleType == "motorcycle"){
            $vehicle->motorcycle()->save(new Motorcycle($motorCycle));
        } else if ($vehicleType == "car") {
            $vehicle->car()->save(new Car($car));
        }

        return $vehicle;
    }

    public function delete(Vehicle $vehicle)
    {
        $this->filter(['id' => $vehicle->id])->delete();
    }
}