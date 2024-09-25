<?php

namespace App\Http\Controllers;

use App\Models\AssistanceType;
use Illuminate\Http\Request;

class AssistanceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assistanceTypes = AssistanceType::orderBy('name')->get();
        return view('assistance-types.index', compact('assistanceTypes'));
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
                'name' => 'required|string|max:255|unique:assistance_types',
                'description' => 'nullable|string|max:1000',
            ]);

            $assistanceType = AssistanceType::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Assistance type created successfully.',
                'data' => $assistanceType
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the assistance type.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AssistanceType $assistanceType)
    {
        try {
            $assistanceType->load(['assistanceEvents' => function($query) {
                $query->orderBy('event_date', 'asc');
            }]);

            return view('assistance-types.show', compact('assistanceType'));
        } catch (\Exception $e) {
            return redirect()->route('assistance-types.index')
                ->with('error', 'An error occurred while retrieving the assistance type.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssistanceType $assistanceType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssistanceType $assistanceType)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:assistance_types,name,' . $assistanceType->id,
                'description' => 'nullable|string|max:1000',
            ]);

            $assistanceType->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Assistance type updated successfully.',
                'data' => $assistanceType
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the assistance type.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssistanceType $assistanceType)
    {
        try {
            // Check if the assistance type has been availed
            if ($assistanceType->assistanceEvents()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete this assistance type as it has already been availed.'
                ], 422);
            }

            $assistanceType->delete();

            return response()->json([
                'success' => true,
                'message' => 'Assistance type deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the assistance type.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
