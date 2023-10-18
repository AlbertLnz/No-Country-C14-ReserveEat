<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'reservation_date',
        'quantity_people',
        'state_reservation',
        'price',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function reservation_tables()
    {
        return $this->belongsToMany('App\Models\ReservationTable');
    }
}

