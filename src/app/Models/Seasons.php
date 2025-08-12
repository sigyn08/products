<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seasons extends Model
{
    public function products()
    {
        return $this->belongsToMany(Products::class, 'product_season', 'season_id', 'product_id');
    }
}
