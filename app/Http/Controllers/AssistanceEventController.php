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
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'assistance_type_id' => 'required|integer|exists:assistance_types,id', // Ensure the ID exists
                'event_name' => 'required|string|max:255',
                'venue' => 'required|string|max:255', // Changed from event_venue to venue
                'event_date' => 'required|date|after_or_equal:today', // Ensure the date is today or in the future
                'amount' => 'required|numeric|min:0', // Changed from event_amount to amount
                'notes' => 'nullable|string', // Changed from event_notes to notes
            ]);

            // Create the event
            $event = AssistanceEvent::create($validatedData);

            return response()->json([
                'success' => true,
                'data' => $event,
            ], 201); // Return 201 Created status
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors(),
            ], 422); // Return 422 Unprocessable Entity status
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error creating event: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the event. Please try again later.',
            ], 500); // Return 500 Internal Server Error status
        }
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
    public function update(Request $request, AssistanceEvent $assistance_schedule)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'assistance_type_id' => 'required|integer|exists:assistance_types,id',
                'event_name' => 'required|string|max:255',
                'venue' => 'required|string|max:255',
                'event_date' => 'required|date|after_or_equal:today',
                'amount' => 'required|numeric|min:0',
                'notes' => 'nullable|string',
            ]);

            // Update the event
            //$assistanceEvent = AssistanceEvent::findOrFail($request->id);
            $assistance_schedule->update($validatedData);

            return response()->json([
                'success' => true,
                'data' => $assistance_schedule,
            ], 200); // Return 200 OK status
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors(),
            ], 422); // Return 422 Unprocessable Entity status
        } catch (\Exception $e) {
            \Log::error('Error updating event: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the event. Please try again later.',
            ], 500); // Return 500 Internal Server Error status
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssistanceEvent $assistance_schedule)
    {
        try {
            // Check if the assistance type has been availed
            //$assistanceEvent = AssistanceEvent::findOrFail($assistanceEvent->id);
            if ($assistance_schedule->assistanceReceived()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete this event. Beneficiaries already received this assistance'
                ], 422);
            }

            $assistance_schedule->delete();

            return response()->json([
                'success' => true,
                'message' =>'Event deleted successfully!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the Event.',
                'error' => $e->getMessage()
            ], 500);
        }
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
