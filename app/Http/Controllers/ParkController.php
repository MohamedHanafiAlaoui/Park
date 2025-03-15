<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Park;
use Illuminate\Http\Request;

class ParkController extends Controller
{
    public function index()
    {
        return response()->json(Park::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number_places' => 'required|integer',
        ]);

        $park = Park::create([
            'name' => $request->name,
            'number_places' => $request->number_places,
        ]);

        return response()->json($park, 201);
    }

    public function show($id)
    {
        $park = Park::findOrFail($id);
        return response()->json($park);
    }

    public function update(Request $request, $id)
    {
        $park = Park::findOrFail($id);

        $request->validate([
            'name' => 'string|max:255',
            'number_places' => 'integer',
        ]);

        // Only update the fields if they are provided in the request
        $park->update(array_filter([
            'name' => $request->name,
            'number_places' => $request->number_places,
        ]));

        return response()->json($park);
    }

    public function destroy($id)
    {
        $park = Park::findOrFail($id);
        $park->delete();

        return response()->json(['message' => 'Park deleted successfully.']);
    }
}


