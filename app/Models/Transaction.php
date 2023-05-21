<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'UserID',
        'TransCode',
        'TransDate',
        'CustName',
        'TotalRoomPrice',
        'TotalExtraCharge',
        'FinalTotal',
    ];

    public function detailTransactions()
    {
        return $this->hasMany(DetailTransaction::class, 'TransID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }
}
