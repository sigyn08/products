<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
        'seasons'
    ];

    public function seasons()
    {
        return $this->belongsToMany(Seasons::class, 'product_season', 'product_id', 'season_id');
    }

    
}
