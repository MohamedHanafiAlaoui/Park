<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Park extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'number_places',
        'reservation_count',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
