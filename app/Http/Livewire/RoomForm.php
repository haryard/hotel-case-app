<?php

namespace App\Http\Livewire;

use App\Models\Room;
use Livewire\Component;
use App\Models\RoomType;

class RoomForm extends Component
{
    public $roomId;
    public $roomName;
    public $roomArea;
    public $roomPrice;
    public $roomFacility;
    public $roomTypeId;
    public $roomTypes;

    protected $rules = [
        'roomName' => 'required',
        'roomArea' => 'required',
        'roomPrice' => 'required|numeric',
        'roomFacility' => 'nullable',
        'roomTypeId' => 'required',
    ];

    public function mount($roomId = null)
    {
        $this->roomId = $roomId;
        $this->roomTypes = RoomType::pluck('RoomType', 'id');

        if ($roomId) {
            $room = Room::findOrFail($roomId);
            $this->roomName = $room->RoomName;
            $this->roomArea = $room->Area;
            $this->roomPrice = $room->Price;
            $this->roomFacility = $room->Facility;
            $this->roomTypeId = $room->RoomTypeID;
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        if ($this->roomId) {
            $room = Room::findOrFail($this->roomId);
            $room->update([
                'RoomName' => $this->roomName,
                'Area' => $this->roomArea,
                'Price' => $this->roomPrice,
                'Facility' => $this->roomFacility,
                'RoomTypeID' => $this->roomTypeId,
            ]);
        } else {
            Room::create([
                'RoomName' => $this->roomName,
                'Area' => $this->roomArea,
                'Price' => $this->roomPrice,
                'Facility' => $this->roomFacility,
                'RoomTypeID' => $this->roomTypeId,
            ]);
        }

        session()->flash('success', 'Room saved successfully.');
        return redirect()->route('room.index');
    }

    public function render()
    {
        return view('livewire.room-form');
    }
}
