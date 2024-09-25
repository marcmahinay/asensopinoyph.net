<?php

namespace App\Http\Controllers;

use App\Models\Municity;
use App\Models\Province;
use Illuminate\Http\Request;

class MunicityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $municities = Municity::orderBy('name')->get();
        $provinces = Province::orderBy('name')->get();

        $data = compact(
            'municities',
            'provinces'
        );
        return view('municities.index',$data);
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
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:municities',
                'province_id' => 'required|exists:provinces,id',
            ]);

            $municity = Municity::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Municity created successfully',
                'data' => $municity
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the municity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Municity $municity)
    {
        // Load municipalities and cities related to this province
        $municity->load(['barangays' => function($query) {
            $query->orderBy('name');
        }]);

        //dd($municity);

        return view('municities.show', compact('municity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Municity $municity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Municity $municity)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:municities,name,' . $municity->id,
               // 'province_id' => 'required|exists:provinces,id',
            ]);

            $municity->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Municity updated successfully',
                'data' => $municity
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the municity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Municity $municity)
    {
        try {
            // Check if the municity has related barangays
            if ($municity->barangays()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete municity with associated barangays'
                ], 422);
            }

            $municity->delete();

            return response()->json([
                'success' => true,
                'message' => 'Municity deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the municity',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
