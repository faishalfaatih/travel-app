<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['travel_schedule_id', 'user_id', 'status'];

    public function travelSchedule()
    {
        return $this->belongsTo(TravelSchedule::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
