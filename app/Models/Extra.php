<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    use HasFactory;

    protected $fillable = [
        'DetailTransID',
        'ProductID',
        'Quantity',
    ];

    public function detailTransaction()
    {
        return $this->belongsTo(DetailTransaction::class, 'DetailTransID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID');
    }
}
