<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexSaleRequest;
use App\Http\Requests\SalesRequest;
use App\Http\Resources\SalesResource;
use App\Services\SalesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SalesController extends Controller
{
    protected $salesService;

    public function __construct(SalesService $salesService)
    {
        $this->salesService = $salesService;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/sales/report",
     *     tags={"Sales"},
     *     description="Report Sales Endpoint",
     *     @OA\Parameter(
     *         name="vehicle_type",
     *         in="query",
     *         description="Vehicle Type. Ex: motorcycle|car",
     *         required=false,
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     * )
     */
    public function report(IndexSaleRequest $request)
    {
        $data = $request->validated();

        $salesData = $this->salesService->report($data);

        $paginate = $salesData[0]->with('vehicle')->paginate(10);

        return SalesResource::collection($paginate)
            ->additional([
                'total_revenue' => $salesData[1],
                'total_quantity_sold' => $salesData[2]
            ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/sales",
     *     tags={"Sales"},
     *     description="Sales Create Endpoint",
     *     @OA\RequestBody(
     *          required=true,
     *          description="",
     *          @OA\JsonContent(
     *              required={"vehicle_id","quantity"},
     *              @OA\Property(property="vehicle_id", type="string", format="text", example="blue"),
     *              @OA\Property(property="quantity", type="int", format="test", example=1),
     *          ),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     * )
     */
    public function store(SalesRequest $request)
    {
        $data = $request->validated();

        $sales = $this->salesService->recordSales($data);

        if (! $sales[0]){
            return Response::json(['success' => false], 422);
        }

        return new SalesResource($sales[1]);
    }
}
