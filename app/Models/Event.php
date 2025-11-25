<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $fillable = [
        'name',
        'description',
        'price',
        'date',
        'status',
        'image',
        'link'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    protected $casts = [
        'date' => 'datetime',
    ];
}
