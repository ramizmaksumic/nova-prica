<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }
}
