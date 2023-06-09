<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'RoomTypeID',
        'RoomName',
        'Area',
        'Price',
        'Facility',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'RoomTypeID');
    }

    public function detailTransactions()
    {
        return $this->hasMany(DetailTransaction::class, 'RoomID');
    }
}
