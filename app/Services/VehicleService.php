<?php

declare(strict_types=1);
namespace App\Services;

use App\Models\Vehicle;
use App\Repositories\VehicleRepository;

class VehicleService {
    public $vehicleRepository;

    public function __construct(VehicleRepository $vehicleRepository) {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function getDataVehicle(array $data) : \Jenssegers\Mongodb\Eloquent\Builder
    {
        return $this->vehicleRepository->filter($data);
    }

    public function createVehicle(array $vehicle) : Vehicle {
        return $this->vehicleRepository->create($vehicle);
    }

    public function updateVehicle(Vehicle $vehicle, array $update) : Vehicle {
        return $this->vehicleRepository->update($vehicle, $update);
    }

    public function deleteVehicle(Vehicle $vehicle) {
        return $this->vehicleRepository->delete($vehicle);
    }
}