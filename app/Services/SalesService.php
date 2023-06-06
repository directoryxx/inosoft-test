<?php

declare(strict_types=1);
namespace App\Services;

use App\Models\Vehicle;
use App\Repositories\SaleRepository;
use App\Repositories\VehicleRepository;
use Jenssegers\Mongodb\Eloquent\Builder;

class SalesService {
    public $vehicleRepository;

    public $saleRepository;

    public function __construct(VehicleRepository $vehicleRepository, SaleRepository $saleRepository) {
        $this->vehicleRepository = $vehicleRepository;
        $this->saleRepository = $saleRepository;
    }

    public function recordSales(array $data) : array
    {
        /**
         * Get Vehicle Data
         */
        $vehicle = $this->vehicleRepository->filter(['id' => $data['vehicle_id']])->first();

        /**
         * Check Stock
         */
        if (($vehicle->stock - $data['quantity']) < 0){
            return [false, null];
        }


        $data['price'] = $vehicle->price;
        $data['total_payment'] = $vehicle->price * $data['quantity'];

        $sales = $this->saleRepository->create($data);

        return [true, $sales];
    }

    public function report(array $data) : array
    {
        $dataSales = $this->saleRepository->filter($data);

        $totalRevenue = $this->saleRepository->filter($data)->sum('total_payment');
        $totalQuantitySold = $this->saleRepository->filter($data)->sum('quantity');

        return [$dataSales, $totalRevenue, $totalQuantitySold];
    }
}