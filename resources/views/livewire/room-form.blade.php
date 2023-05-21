<x-slot name="header">
    @if ($roomId)
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Edit Room') }}</h2>
    @else
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{{ __('Create Room') }}}</h2>
    @endif
</x-slot>

<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form wire:submit.prevent="save">

                    <div>
                        <x-input-label for="roomName" :value="__('Room Name')" />
                        <x-text-input id="roomName" class="block mt-1 w-full" type="text" name="roomName"  wire:model="roomName"/>
                        <x-input-error :messages="$errors->get('roomName')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="roomArea" :value="__('Room Area')" />
                        <x-text-input id="roomArea" class="block mt-1 w-full" type="text" name="roomArea"  wire:model="roomArea"/>
                        <x-input-error :messages="$errors->get('roomArea')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="roomPrice" :value="__('Room Price')" />
                        <x-text-input id="roomPrice" class="block mt-1 w-full" type="number" name="roomPrice"  wire:model="roomPrice"/>
                        <x-input-error :messages="$errors->get('roomPrice')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="roomFacility" :value="__('Room Facility')" />
                        <textarea id="roomFacility" wire:model="roomFacility" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                        <x-input-error :messages="$errors->get('roomFacility')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="roomTypeId" :value="__('Room Type')" />
                        <select id="roomTypeId" wire:model="roomTypeId" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Select Room Type</option>
                            @foreach ($roomTypes as $id => $type)
                                <option value="{{ $id }}">{{ $type }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('roomTypeId')" class="mt-2" />
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
