<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderTripRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\TravelRequestResource;
use App\Models\TravelRequest;
use App\Notifications\TravelRequestStatusChanged;
use Illuminate\Http\Request;

class OrderTripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'destino', 'data_ida_inicio', 'data_ida_fim', 'data_volta_inicio', 'data_volta_fim']);
        $travelRequests = TravelRequest::filter($filters)->get();

        return TravelRequestResource::collection($travelRequests);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderTripRequest $request)
    {
        $validatedData = $request->validated();

        $mappedData = [
            'requester_name' => $validatedData['nome_solicitante'],
            'requester_email' => $validatedData['email_solicitante'],
            'destination' => $validatedData['destino'],
            'departure_date' => $validatedData['data_ida'],
            'return_date' => $validatedData['data_volta'],
            'travel_status_id' => TravelRequest::getStatusId($validatedData['status'] ?? 'solicitado'),
        ];

        $orderTrip = TravelRequest::create($mappedData);

        return response()->json([
            'message' => 'Viagem solicitada com sucesso.',
            'data' => new TravelRequestResource($orderTrip)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $travelRequest = TravelRequest::find($id);

        if (!$travelRequest) {
            return response()->json([
                'message' => 'Viagem não encontrada.'
            ], 404);
        }

        return new TravelRequestResource($travelRequest);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(UpdateStatusRequest $request, string $id)
    {
        $travel = TravelRequest::find($id);

        if ($travel === null) {
            return response()->json([
                'message' => 'Viagem não encontrada.'
            ], 404);
        }

        $newStatusId = TravelRequest::getStatusId($request->input('status'));

        if ($travel->travel_status_id === $newStatusId) {
            return response()->json([
                'message' => 'O status da viagem já é ' . $request->input('status') . '.'
            ], 200);
        }

        $travel->travel_status_id = $newStatusId;
        $travel->save();

        $travel->notify(new TravelRequestStatusChanged($request->input('status')));

        return response()->json([
            'message' => 'Status atualizado com sucesso.',
            'data' => new TravelRequestResource($travel)
        ]);
    }
}
