<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'TransID',
        'RoomID',
        'Days',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'TransID');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'RoomID');
    }

    public function extras()
    {
        return $this->hasMany(Extra::class, 'DetailTransID');
    }
}
