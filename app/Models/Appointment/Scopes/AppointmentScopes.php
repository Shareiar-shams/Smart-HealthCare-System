<?php

namespace App\Models\Appointment\Scopes;

trait AppointmentScopes
{
    public function scopeForDoctor($q, $doctorId) { 
        return $q->where('doctor_id', $doctorId); 
    }
    public function scopeBetween($q, $start, $end) {
      return $q->where(function($s) use ($start,$end){
        $s->whereBetween('start_at', [$start, $end])
          ->orWhereBetween('end_at', [$start, $end])
          ->orWhereRaw('? BETWEEN start_at AND end_at', [$start])
          ->orWhereRaw('? BETWEEN start_at AND end_at', [$end]);
      });
    }
}