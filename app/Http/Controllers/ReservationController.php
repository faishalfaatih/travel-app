<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\TravelSchedule;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function bookTicket(Request $request)
    {
        $request->validate([
            'travel_schedule_id' => 'required|exists:travel_schedules,id'
        ]);

        $schedule = TravelSchedule::find($request->travel_schedule_id);

        // Cek apakah masih ada kuota
        if ($schedule->quota <= 0) {
            return response()->json(['message' => 'Kuota habis, tiket tidak dapat dipesan'], 400);
        }

        // Kurangi kuota
        $schedule->quota -= 1;
        $schedule->save();

        // Simpan pemesanan
        $reservation = Reservation::create([
            'travel_schedule_id' => $schedule->id,
            'user_id' => Auth::id(),
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Tiket berhasil dipesan',
            'reservation' => $reservation
        ], 201);
    }

    public function bookingHistory()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->with('travelSchedule')
            ->get();

        return response()->json($reservations);
    }

}
