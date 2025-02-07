<?php

namespace App\Http\Controllers;

use App\Models\TravelSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class TravelScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(TravelSchedule::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'destination' => 'required|string|max:255',
                'departure_time' => 'required|date',
                'quota' => 'required|integer|min:1',
                'ticket_price' => 'required|numeric|min:0'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            // Simpan data ke database
            $schedule = TravelSchedule::create([
                'destination' => $request->destination,
                'departure_time' => $request->departure_time,
                'quota' => $request->quota,
                'ticket_price' => $request->ticket_price
            ]);
    
            return response()->json([
                'message' => 'Jadwal travel berhasil dibuat',
                'data' => $schedule
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $travelSchedule = TravelSchedule::find($id);
        if (!$travelSchedule) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }

        return response()->json($travelSchedule);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $travelSchedule = TravelSchedule::find($id);
        if (!$travelSchedule) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }

        $request->validate([
            'destination' => 'sometimes|string|max:255',
            'departure_time' => 'sometimes|date',
            'quota' => 'sometimes|integer|min:1',
            'ticket_price' => 'sometimes|numeric|min:0',
        ]);

        $travelSchedule->update($request->all());

        return response()->json(['message' => 'Jadwal travel berhasil diperbarui', 'data' => $travelSchedule]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $travelSchedule = TravelSchedule::find($id);
        if (!$travelSchedule) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }

        $travelSchedule->delete();

        return response()->json(['message' => 'Jadwal travel berhasil dihapus']);
    }

    public function availableSchedules(Request $request)
    {
        $query = TravelSchedule::query();

        // Filter berdasarkan tujuan travel
        if ($request->has('destination')) {
            $query->where('destination', 'like', '%' . $request->destination . '%');
        }

        // Filter berdasarkan tanggal keberangkatan
        if ($request->has('departure_date')) {
            $query->whereDate('departure_time', $request->departure_date);
        }

        // Hanya jadwal yang masih memiliki kuota
        $query->where('quota', '>', 0);

        $schedules = $query->get();

        return response()->json($schedules);
    }
}
