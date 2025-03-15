<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Park;  // Add Park model
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return response()->json(Reservation::with(['user', 'park'])->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'park_id' => 'required|exists:parks,id',
            'reservation_date' => 'required|date',
            'number_of_places' => 'required|integer',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        // Check if there are enough places available in the park
        $park = Park::findOrFail($request->park_id);
        if ($park->number_places < $request->number_of_places) {
            return response()->json(['message' => 'Not enough places available.'], 400);
        }

        $reservation = Reservation::create([
            'user_id' => $request->user_id,
            'park_id' => $request->park_id,
            'reservation_date' => $request->reservation_date,
            'number_of_places' => $request->number_of_places,
            'status' => $request->status,
        ]);

        return response()->json($reservation, 201);
    }

    public function show($id)
    {
        $reservation = Reservation::with(['user', 'park'])->findOrFail($id);
        return response()->json($reservation);
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        // Only update the status if it's provided in the request
        $reservation->update([
            'status' => $request->status ?? $reservation->status,
        ]);

        return response()->json($reservation);
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json(['message' => 'Reservation deleted successfully.']);
    }
}


