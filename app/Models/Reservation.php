<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{

    protected $with = [
        'event:id,name,date,status',
        'user:id,name',
        'table:id,name'
    ];

    protected $fillable = [
        'event_id',
        'user_id',
        'table_id',
        'status',
        'num_people',
        'notes',

    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
