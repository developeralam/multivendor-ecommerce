<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'images' => 'json',
    ];
    public function scopeStatus($query, $status)
    {
        $query->where('status', $status);
    }
    public function scopeSold($query)
    {
        $query->where('sale', 1);
    }
    public function scopeConditions($query, $condition)
    {
        $query->where('conditions', $condition);
    }
}
