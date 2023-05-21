<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reservation') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center">
                        <h2 class="flex-grow font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                          {{ __('Reservation History') }}
                        </h2>
                        <x-secondary-button>
                            <a href="{{ route('reservation.create') }}">{{ __('Create New Reservation') }}</a>
                        </x-secondary-button>
                    </div>
                    <hr class="my-4">
                    @livewire('transaction-user-table')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
