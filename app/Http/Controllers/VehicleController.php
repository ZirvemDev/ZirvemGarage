<?php

namespace App\Http\Controllers;

use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use App\Services\Garage\GarageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class VehicleController extends Controller
{
    /**
     * The service instance
     */
    private GarageService $garageService;

    /**
     * Constructor
     */
    public function __construct(GarageService $garageService)
    {
        $this->garageService = $garageService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {

        $this->authorize('list', Vehicle::class);

        return $this->garageService->index($request->all());
    }

    public function store(Request $request)
    {
        //$this->authorize('create', Vehicle::class);

        $data = $request->validate([
            'system_id' => ['required'],
            'plate' => ['required'],
            'doc_number' => ['required'],
            'garage_id' => ['required'],
        ]);

        try {
            $vehicle = Vehicle::create($data);

            if ($vehicle) {
                return response()->json([
                    'status' => "success",
                    'data' => new VehicleResource($vehicle)
                ]);
            } else {
                return response()->json(['success' => false], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'false',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Vehicle $vehicle)
    {
        $this->authorize('view', $vehicle);

        return new VehicleResource($vehicle);
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);

        $data = $request->validate([
            'system_id' => ['required'],
            'plate' => ['required'],
            'doc_number' => ['required'],
        ]);

        $vehicle->update($data);

        return new VehicleResource($vehicle);
    }

    public function destroy(Vehicle $vehicle)
    {
        $this->authorize('delete', $vehicle);

        $vehicle->delete();

        return response()->json();
    }
}
