<?php

namespace App\Http\Livewire;

use App\Models\Room;
use App\Models\Extra;
use App\Models\Product;
use Livewire\Component;
use App\Models\RoomType;
use App\Models\Transaction;
use App\Models\DetailTransaction;
use Illuminate\Support\Facades\Auth;

class ReservationForm extends Component
{
    public $reservationCode;
    public $reservationDate;
    public $customerName;
    public $totalRooms = 1;
    public $roomTypes;
    public $roomTypeId;
    public $days;
    public $products;
    public $extras = [];
    public $totalExtraCharges;
    public $totalRoomPrices;
    public $totalFinal;

    public $rules = [
        'roomTypes' => 'required'
    ];


    public function mount(){
        $this->reservationCode = 'TR'. strtoupper(uniqid());
        $this->reservationDate = now()->format('Y-m-d');
        $this->roomTypes = RoomType::all();
        $this->products = Product::all();
    }
    
    public function calculateExtraCharges()
    {
        $totalExtraCharges = 0;
        
        foreach ($this->extras as $productID => $quantity) {
            $product = Product::find($productID);
            $totalExtraCharges += ($product->Price * $quantity);
        }
        
        return $totalExtraCharges;
    }
    
    public function calculateRoomPrice()
    {
        $totalRoomPrice = 0;

        $roomType = RoomType::find($this->roomTypeId);
        if ($roomType) {
            $room = $roomType->rooms()->first();
            if ($room) {
                $roomPrice = $room->Price;
                $totalRoomPrice = ($roomPrice * $this->days);
            }
        }
        
        return $totalRoomPrice;
    }
    
    public function calculateTotalExtraCharges()
    {
        $totalExtraCharges = 0;

        foreach ($this->extras as $productID => $quantity) {
            $product = Product::find($productID);
            $totalExtraCharges += ($product->Price * $quantity)* $this->totalRooms;
        }

        $this->totalExtraCharges = $totalExtraCharges;
        return $totalExtraCharges;
    }

    public function calculateTotalRoomPrice()
    {
        $totalRoomPrice = 0;

        $roomType = RoomType::find($this->roomTypeId);
        if ($roomType) {
            $room = $roomType->rooms()->first();
            if ($room) {
                $roomPrice = $room->Price;
                $totalRoomPrice = ($roomPrice * $this->days) * $this->totalRooms ;
            }
        }

        $this->totalRoomPrices = $totalRoomPrice;
        return $totalRoomPrice;
    }

    public function calculateTotal()
    {
        return $this->totalFinal = $this->calculateTotalRoomPrice() + $this->calculateTotalExtraCharges();
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();
        if (!$this->customerName) {
            $this->customerName = $user->name;
        }

        $transaction = new Transaction();
        $transaction->UserID = $user->id;
        $transaction->TransCode = $this->reservationCode;
        $transaction->TransDate = $this->reservationDate;
        $transaction->CustName = $this->customerName;
        $transaction->TotalRoomPrice = $this->totalRoomPrices;
        $transaction->TotalExtraCharge = $this->totalExtraCharges;
        $transaction->FinalTotal = $this->totalFinal;
        $transaction->save();
        
        $roomType = RoomType::find($this->roomTypeId);
        if ($roomType) {
            $rooms = $roomType->rooms()->limit($this->totalRooms)->get();
            foreach ($rooms as $room) {
                $detailTransaction = new DetailTransaction();
                $detailTransaction->TransID = $transaction->id;
                $detailTransaction->RoomID = $room->id;
                $detailTransaction->Days = $this->days;
                $detailTransaction->SubTotalRoom = $this->calculateRoomPrice();
                $detailTransaction->ExtraCharges = $this->calculateExtraCharges();
                $detailTransaction->save();
                
                foreach ($this->extras as $productID => $quantity) {
                    $extra = new Extra();
                    $extra->DetailTransID = $detailTransaction->id;
                    $extra->ProductID = $productID;
                    $extra->Quantity = $quantity;
                    $extra->save();
                }
            }
        }

        session()->flash('success', 'Reservation Created successfully.');

        return redirect()->route('reservation.index');
    }

    public function render()
    {
        return view('livewire.reservation-form');
    }
}
