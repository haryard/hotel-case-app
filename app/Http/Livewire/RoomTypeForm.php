<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\RoomType;

class RoomTypeForm extends Component
{
    public $roomTypeId;
    public $roomTypeName;

    protected $rules = [
        'roomTypeName' => 'required',
    ];

    public function mount($roomTypeId = null)
    {
        $this->roomTypeId = $roomTypeId;

        if ($roomTypeId) {
            $roomType = RoomType::findOrFail($roomTypeId);
            $this->roomTypeName = $roomType->RoomType;
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        if ($this->roomTypeId) {
            $roomType = RoomType::findOrFail($this->roomTypeId);
            $roomType->update([
                'RoomType' => $this->roomTypeName,
            ]);
        } else {
            RoomType::create([
                'RoomType' => $this->roomTypeName,
            ]);
        }

        session()->flash('success', 'Room type saved successfully.');

        return redirect()->route('room.index');
    }

    public function render()
    {
        return view('livewire.room-type-form');
    }
}
