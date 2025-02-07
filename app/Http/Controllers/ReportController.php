<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\TravelSchedule;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function passengersPerTravel($id)
    {
        $travelSchedule = TravelSchedule::find($id);
        if (!$travelSchedule) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }

        $passengerCount = Reservation::where('travel_schedule_id', $id)->count();

        return response()->json([
            'travel_schedule' => $travelSchedule,
            'passenger_count' => $passengerCount
        ]);
    }

    public function passengerList($id)
    {
        $travelSchedule = TravelSchedule::find($id);
        if (!$travelSchedule) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }

        $passengers = Reservation::where('travel_schedule_id', $id)->with('user')->get();

        return response()->json([
            'travel_schedule' => $travelSchedule,
            'passengers' => $passengers
        ]);
    }
}
