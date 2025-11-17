<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'cost',
        'stock'
    ];

    public function setNameAttribute($value) {
        $this->attributes['name'] = strtoupper($value);
    }

    public function orders() {
        return $this->belongsToMany(Order::class, 'order_product')->withPivot('quantity', 'price', 'cost')->withTimestamps();
    }
}
