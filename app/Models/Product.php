<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'ProductName',
        'Price',
    ];

    public function extras()
    {
        return $this->hasMany(Extra::class, 'ProductID');
    }
}
