<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'TransCode',
        'TransDate',
        'user_id',
    ];

    public function detailTransactions()
    {
        return $this->hasMany(DetailTransaction::class, 'TransID');
    }
}
