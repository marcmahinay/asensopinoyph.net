<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use App\Models\AssistanceEvent;
use App\Models\Event;

class BeneficiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*  $beneficiaries = Beneficiary::select('last_name', 'first_name', 'middle_name', 'id', 'asenso_id', 'sex', 'birth_date', 'status', 'barangay_id', 'image_path')
            ->with([
                'barangay:id,name,municity_id',
                'barangay.municity:id,name,province_id',
                'barangay.municity.province:id,name'
            ])
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->paginate(25); */

        // dd($beneficiaries);
        return view('beneficiaries.index'); //, compact('beneficiaries'));
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
    public function show(Beneficiary $beneficiary)
    {
        // Validate that the beneficiary exists
        if (!$beneficiary->exists) {
            abort(404, 'Beneficiary not found.');
        }

        // Load the relationships
        $beneficiary->load('voucherCodes', 'assistanceReceived');

        // Get upcoming AssistanceEvents
       /*  $upcomingEvents = \App\Models\AssistanceEvent::where('event_date', '=', now()->format('Y-m-d'))
            ->orderBy('event_date')
            ->get(); */

         $upcomingEvents = \App\Models\AssistanceEvent::with('assistanceType') // Load the assistance type relationship
            ->where('event_date', '=', now()->format('Y-m-d'))
            ->orderBy('event_date')
            ->get();

        // Check if the beneficiary has received assistance for each event
        $eventSchedule = $upcomingEvents->map(function ($event) use ($beneficiary) {
            $assistanceReceived = $beneficiary->assistanceReceived->firstWhere('assistance_event_id', $event->id);
            return [
                'event' => $event,
                'received' => $assistanceReceived !== null,
                'received_at' => $assistanceReceived ? $assistanceReceived->created_at : null,
            ];
        });

        //dd($eventSchedule);

        // Return the view with the beneficiary data and event schedule
        return view('beneficiaries.show', compact('beneficiary', 'eventSchedule'));
    }

    public function showByAsensoId($asensoId)
    {
        $beneficiary = Beneficiary::where('asenso_id', $asensoId)->firstOrFail();

        // Load the relationships
        $beneficiary->load('voucherCodes', 'assistanceReceived');


        // Check if the beneficiary has received assistance for each event
        $eventSchedule = $upcomingEvents->map(function ($event) use ($beneficiary) {
            $assistanceReceived = $beneficiary->assistanceReceived->firstWhere('assistance_event_id', $event->id);
            return [
                'event' => $event,
                'received' => $assistanceReceived !== null,
                'received_at' => $assistanceReceived ? $assistanceReceived->created_at : null,
            ];
        });

        // Return the view with the beneficiary data and event schedule
        return view('beneficiaries.show', compact('beneficiary', 'eventSchedule'));
    }

    public function cancelAssistance(Beneficiary $beneficiary, Event $event)
    {
        try {
            $assistance = $beneficiary->assistanceReceived()
                ->where('assistance_event_id', $event->id)
                ->firstOrFail();

            $assistance->delete();

            return response()->json(['success' => true, 'message' => 'Assistance cancelled successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to cancel assistance'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Beneficiary $beneficiary)
    {
        //
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $parts = explode(',', $query);

        $beneficiaries = Beneficiary::query()
            ->where(function ($q) use ($parts) {
                $q->where('last_name', 'LIKE', trim($parts[0]) . '%');

                if (isset($parts[1])) {
                    $q->where('first_name', 'LIKE', '%' . trim($parts[1]) . '%');
                }

                if (isset($parts[2])) {
                    $q->where('middle_name', 'LIKE', '%' . trim($parts[2]) . '%');
                }
            })
            ->orWhere('asenso_id', 'LIKE', "%$query%")
            ->with('barangay.municity.province')
            ->get();

        //$html = view('beneficiaries.partials.table-body', compact('beneficiaries'))->render();

        return response()->json($beneficiaries);
    }

    /*  public function search(Request $request)
    {
        $term = $request->input('term');
        $barangays = Barangay::with(['municity.province'])
            ->where('name', 'like', "%{$term}%")
            ->orWhereHas('municity', function ($query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhereHas('province', function ($query) use ($term) {
                        $query->where('name', 'like', "%{$term}%");
                    });
            })
            ->get();

        return response()->json($barangays);
    } */
}
