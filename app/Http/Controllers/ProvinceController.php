<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provinces = Province::orderBy('name')->get();

        $data = compact('provinces');
        return view('provinces.index',$data);
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
    public function show(Province $province)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the province by ID
        $province = Province::find($id);

        // Check if the province exists
        if (!$province) {
            return response()->json([
                'success' => false,
                'message' => 'Province not found.'
            ], 404);
        }

        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'region' => 'required|string|max:255',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Update province details
            $province->name = $request->input('name');
            $province->region = $request->input('region');
            $province->save();

            // Return a successful JSON response
            return response()->json([
                'success' => true,
                'message' => 'Province updated successfully.',
                'data' => $province
            ], 200);
        } catch (\Exception $e) {
            // Return an error JSON response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the province.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        //
    }
}
