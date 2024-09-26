<?php

namespace App\Http\Controllers;

use App\Models\AssistanceEvent;
use App\Models\AssistanceReceived;
use App\Models\Beneficiary;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function qrScanner($eventId)
    {
        $event = AssistanceEvent::find($eventId);
        // Check if the event date is the current date\
        $data = compact('event');
        if (!$event || $event->event_date->toDateString() !== now()->toDateString()) {
            //return response()->json(['success' => false, 'message' => 'QR scanner is not available for this event.'], 403);
            return view('qr.qr-not-available',$data);
        }

        return view('qr.qr-scanner',$data);
    }

    public function verify(Request $request)
    {
        try {
            // Validate the incoming request
            $validatedData = $request->validate([
                'qrCode' => 'required|string|max:255', // Example validation rule
                'event_id' => 'required|numeric',
            ]);

            $qrCode = $request->qrCode;

            if (strpos($qrCode, 'https://') === 0) {
                // Parse the qrCode URL and get the last segment
                $qrCode = basename(parse_url($qrCode, PHP_URL_PATH));
                // Now you can use $lastSegment as needed
            }

            $beneficiary = Beneficiary::where('asenso_id', $qrCode)->firstOrFail();
            $event = AssistanceEvent::findOrFail($request->event_id);

            $existingAssistance = AssistanceReceived::where('beneficiary_id', $beneficiary->id)
                ->where('assistance_event_id', $event->id)
                ->first();

            if ($existingAssistance) {
                return response()->json(['success' => true, 'message' => 'Already Claimed','name' => $beneficiary->last_name . ',' . $beneficiary->first_name . ' ' . $beneficiary->middle_name]);
            }

            $assistanceReceived = AssistanceReceived::create([
                'beneficiary_id' => $beneficiary->id,
                'assistance_event_id' => $event->id,
                'amount_received' => $event->amount,
                'status' => 'claimed',
                'received_at' => now(),
            ]);

            return response()->json(['success' => true, 'message' => 'Claimed','name' => $beneficiary->last_name . ',' . $beneficiary->first_name . ' ' . $beneficiary->middle_name]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' =>  'Invalid QR'], 500);
        }
    }
}
