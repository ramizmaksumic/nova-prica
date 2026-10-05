<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Table extends Model
{
    protected $fillable = [
        'name',
        'min_capacity',
        'max_capacity',
        'description',

    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
