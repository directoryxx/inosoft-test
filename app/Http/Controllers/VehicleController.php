<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleStoreRequest;
use App\Http\Requests\VehicleUpdateRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use App\Services\VehicleService;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    protected $vehicleService;

    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/vehicles",
     *     tags={"Vehicle"},
     *     description="Vehicle Index Endpoint",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     * )
     */
    public function index()
    {
        $data = $this->vehicleService->getDataVehicle([])->paginate(10);

        return VehicleResource::collection($data);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/vehicles",
     *     tags={"Vehicle"},
     *     description="Vehicle Create Endpoint",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Example: https://pastebin.com/Yd5aS7yy",
     *          @OA\JsonContent(
     *          ),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     * )
     */
    public function store(VehicleStoreRequest $request)
    {
        $data = $request->validated();

        $vehicle = $this->vehicleService->createVehicle($data);

        return new VehicleResource($vehicle);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/vehicles/{id}",
     *     tags={"Vehicle"},
     *     description="Vehicle Get Endpoint",
     *     @OA\Parameter(
     *         description="ID of vehicle",
     *         in="path",
     *         name="id",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     * )
     */
    public function show(Vehicle $vehicle)
    {
        return new VehicleResource($vehicle);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/vehicles/{id}",
     *     tags={"Vehicle"},
     *     description="Vehicle Update Endpoint",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Example: https://pastebin.com/Yd5aS7yy",
     *          @OA\JsonContent(
     *              required={"color","year", "price"},
     *              @OA\Property(property="color", type="string", format="text", example="blue"),
     *              @OA\Property(property="year", type="string", format="test", example="1000"),
     *              @OA\Property(property="price", type="string", format="test", example="1000"),
     *          ),
     *     ),
     *     @OA\Parameter(
     *         description="ID of vehicle",
     *         in="path",
     *         name="id",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     * )
     */
    public function update(VehicleUpdateRequest $request, Vehicle $vehicle)
    {
        $data = $request->validated();

        $vehicle = $this->vehicleService->updateVehicle($vehicle, $data);

        return new VehicleResource($vehicle);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/vehicles/{id}",
     *     tags={"Vehicle"},
     *     description="Vehicle Delete Endpoint",
     *     @OA\Parameter(
     *         description="ID of vehicle",
     *         in="path",
     *         name="id",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     * )
     */
    public function destroy(Vehicle $vehicle)
    {
        $this->vehicleService->deleteVehicle($vehicle);

        return ['success' => true];
    }
}
