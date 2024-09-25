<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Municity;
use App\Models\Province;
use Illuminate\Http\Request;

class BarangayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangays = Barangay::orderBy('name')->get();
        $municities = Municity::orderBy('name')->get();
        $provinces = Province::orderBy('name')->get();

        $data = compact(
            'barangays',
            'municities',
            'provinces'
        );

        return view('barangays.index', $data);
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
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:barangays,name',
            'municity_id' => 'required|exists:municities,id',
            // Add other fields as needed
        ]);

        try {
            $barangay = Barangay::create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Barangay created successfully',
                'data' => $barangay
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create barangay',
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Barangay $barangay)
    {

        $barangay->load(['beneficiaries' => function ($query) {
            $query->orderBy('last_name');
            $query->orderBy('first_name');
            $query->orderBy('middle_name');
        }]);

        //dd($barangay);


        return view('barangays.show', compact('barangay'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barangay $barangay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barangay $barangay)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:barangays,name,' . $barangay->id,
            //'municity_id' => 'required|exists:municities,id',
            // Add other fields as needed
        ]);

        try {
            $barangay->update($validated);
            return response()->json([
                'success' => true,
                'message' => 'Barangay updated successfully',
                'data' => $barangay
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update barangay',
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barangay $barangay)
    {
        try {
            // Check if the barangay has any associated beneficiaries
            if ($barangay->beneficiaries()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete barangay with associated beneficiaries',
                ], 422);
            }

            $barangay->delete();

            return response()->json([
                'success' => true,
                'message' => 'Barangay deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete barangay',
                'errors' => [$e->getMessage()],
            ], 500);
        }
    }

    public function search(Request $request)
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
    }
}
