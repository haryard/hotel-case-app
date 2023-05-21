<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{{ __('Create Room Type') }}}</h2>
    <div>
        <x-input-label class="text-xs">
            Reservation Code : {{ $reservationCode }}
        </x-input-label>
        <x-input-label class="text-xs">
            Reservation Date  : {{ $reservationDate }}
        </x-input-label>
    </div>
</x-slot>

<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form wire:submit.prevent="save">
                    <div>
                        <x-input-label for="customerName" :value="__('Customer Name')" />
                        <x-text-input id="customerName" class="block mt-1 w-full" type="text" name="customerName"  wire:model="customerName"/>
                    </div>
                    
                    <div class="mt-2">
                        <x-input-label for="totalRooms" :value="__('Total Request Rooms')" />
                        <x-text-input id="totalRooms" class="block w-full mt-1" type="number" min="1" name="totalRooms"  wire:model="totalRooms"/>
                    </div>

                    <div class="mt-2">
                        <x-input-label for="roomTypeId" :value="__('Room Type')" />
                        <select id="roomTypeId" wire:model="roomTypeId" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Select Room Type</option>
                            @foreach ($roomTypes as $roomType)
                                <option value="{{ $roomType->id }}">{{ $roomType->RoomType }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-2">
                        <x-input-label for="days" :value="__('Days Stayd')" />
                        <x-text-input id="days" class="block mt-1 w-full" type="number" min="1" name="days"  wire:model="days"/>
                    </div>

                    <div class="mt-2">
                        <h5>Extra Options per Room:</h5>
                        <div>
                            @foreach ($products as $product)
                                <x-input-label wire:model="extras.{{ $product->id }}">
                                    {{ $product->ProductName }}
                                </x-input-label>
                                <x-text-input  class="block mt-1 w-full" type="number" min="0"
                                    wire:model="extras.{{ $product->id }}"
                                    wire:change="calculateTotalExtraCharges"/>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="mt-2">
                        <h5>Total Price:</h5>
                        <x-input-label class="text-xs">
                            Total Extra Charges : {{ $totalExtraCharges }}
                        </x-input-label>
                        <x-input-label class="text-xs">
                            Total Room Price  : {{ $this->calculateTotalRoomPrice() }}
                        </x-input-label>
                        <x-input-label class="text-xs">
                            Total Final  : {{ $this->calculateTotal() }}
                        </x-input-label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-3">
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
