<?php

namespace App\Http\Controllers;

use App\Models\AssistanceEvent;
use App\Models\AssistanceReceived;
use App\Models\AssistanceType;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssistanceEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = AssistanceEvent::orderBy('event_date', 'desc')->get();

        $assistanceTypes = AssistanceType::orderBy('name', 'asc')->get();
        $data = compact(['events','assistanceTypes']);
        return view('assistance-events.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AssistanceEvent $assistanceEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssistanceEvent $assistanceEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssistanceEvent $assistanceEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssistanceEvent $assistanceEvent)
    {
        //
    }

    public function cancel(Request $request)
    {
        try {


            $assistanceEvent = AssistanceEvent::findOrFail($request['event_id']);
            $beneficiary = Beneficiary::findOrFail($request['beneficiary_id']);

            // Check if the beneficiary has received this assistance
            $receivedAssistance = $beneficiary->assistanceReceived()
                ->where('assistance_event_id', $assistanceEvent->id)
                ->first();

            if (!$receivedAssistance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Beneficiary has not received this assistance.'], 404);
            }

           // Delete the AssistanceReceived record
        $receivedAssistance->delete();
            // Log the cancellation
            Log::info("Assistance cancelled for Beneficiary ID: {$beneficiary->id}, Event ID: {$assistanceEvent->id}");

            return response()->json([
                'success' => true,
                'message' => 'Assistance cancelled successfully.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found.'], 404);
        } catch (\Exception $e) {
            Log::error('Error cancelling assistance: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while cancelling the assistance.'], 500);
        }
    }



    public function receive(Request $request)
    {
        try {
            $assistanceReceived = AssistanceReceived::create([
                'beneficiary_id' => $request->beneficiary_id,
                'assistance_event_id' => $request->event_id,
                'received_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'received_at' => $assistanceReceived->received_at->format('F j, Y'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
