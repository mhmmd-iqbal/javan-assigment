<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = People::with('parent')->get();

            return response()->json([
                'data' => $data
            ], 200);
        }
        return view('index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $gender = $request->input('gender');
        $parent_id = $request->input('parent_id') ?? null;

        try {
            People::create([
                'name'   => $name,
                'gender' => $gender,
                'parent_id' => $parent_id
            ]);

            return response()->json([
                'message'   => 'Success'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message'   => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = People::get('id', $id)->first();
        
        return response()->json([
            'data'      => $data,
            'message'   => 'Success'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $name = $request->input('name');
        $gender = $request->input('gender');
        $parent_id = $request->input('parent_id') ?? null;

        try {
            People::where('id', $id)->update([
                'name'   => $name,
                'gender' => $gender,
                'parent_id' => $parent_id ?? null
            ]);

            return response()->json([
                'message'   => 'Success'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message'   => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            People::where('id', $id)->delete();
    
            return response()->json([
                'message'   => 'Success'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message'   => $th->getMessage()
            ], 500);
        }
    }
}
