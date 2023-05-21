<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoomType::insert([
            ['RoomType' => 'Standard'],
            ['RoomType' => 'Deluxe'],
            ['RoomType' => 'Suite'],
        ]);

        // Mendapatkan room type berdasarkan namanya
        $standardRoomType = RoomType::where('RoomType', 'Standard')->first();
        $deluxeRoomType = RoomType::where('RoomType', 'Deluxe')->first();
        $suiteRoomType = RoomType::where('RoomType', 'Suite')->first();

        // Menghasilkan data kamar dengan room name yang bertambah increment sesuai tipe kamar
        if ($standardRoomType) {
            for ($i = 100; $i <= 150; $i++) {
                Room::create([
                    'RoomTypeID' => $standardRoomType->id,
                    'RoomName' => 'STD' . $i,
                    'Area' => '20 sqm',
                    'Price' => 500000,
                    'Facility' => 'Wi-Fi, AC, TV',
                ]);
            }
        }

        if ($deluxeRoomType) {
            for ($i = 200; $i <= 225; $i++) {
                Room::create([
                    'RoomTypeID' => $deluxeRoomType->id,
                    'RoomName' => 'DLX' . $i,
                    'Area' => '25 sqm',
                    'Price' => 1500000,
                    'Facility' => 'Wi-Fi, AC, TV',
                ]);
            }
        }

        if ($suiteRoomType) {
            for ($i = 300; $i <= 310; $i++) {
                Room::create([
                    'RoomTypeID' => $suiteRoomType->id,
                    'RoomName' => 'SUI' . $i,
                    'Area' => '30 sqm',
                    'Price' => 3000000,
                    'Facility' => 'Wi-Fi, AC, TV, Minibar',
                ]);
            }
        }
    }
}