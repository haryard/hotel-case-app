<?php

namespace App\Http\Livewire;

use App\Models\Room;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class RoomTable extends DataTableComponent
{
    protected $model = Room::class;
    

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTableWrapperAttributes([
            'default' => false,
            'class' => 'relative overflow-auto shadow-md sm:rounded-lg',
        ]);
        $this->setTableAttributes([
            'default' => false,
            'class' => 'w-full text-sm text-left text-gray-500 dark:text-gray-400',
        ]);
        $this->setTheadAttributes([
            'default' => false,
            'class' => 'text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400',
        ]);
        $this->setThAttributes(function() {
            return [
                'default' => false,
                'class' => 'px-6 py-3',
            ];
        });
        $this->setTrAttributes(function($row, $index) {
            if ($index % 2 === 0) {
                return [
                  'default' => false,
                  'class' => 'bg-white border-b dark:bg-gray-900 dark:border-gray-700',
                ];
              }
        
              return [
                'default' => false,
                'class' => 'border-b bg-gray-50 dark:bg-gray-800 dark:border-gray-700',
              ];
        });
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),
            Column::make("Room Name", "RoomName")
                ->sortable()
                ->searchable(),
            Column::make("Room Type", "roomType.RoomType")
                ->sortable()
                ->eagerLoadRelations()
                ->searchable(),
            Column::make("Area", "Area")
                ->sortable()
                ->collapseOnTablet()
                ->searchable(),
            Column::make("Price", "Price")
                ->sortable()
                ->collapseOnTablet(),
            Column::make("Facility", "Facility")
                ->sortable()
                ->collapseOnTablet()
                ->searchable(),
            ButtonGroupColumn::make('Actions')
                ->collapseOnTablet()
                ->attributes(function($row) {
                    return [
                        'class' => 'space-x-2',
                    ];
                })
                ->buttons([
                    LinkColumn::make('Edit')
                        ->title(fn($row) => 'Edit ' . $row->name)
                        ->location(fn($row) => route('room.edit', ['room' => $row->id]))
                        ->attributes(function($row) {
                            return [
                                'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150',
                            ];
                        }),
                        LinkColumn::make('Delete')
                        ->title(fn($row) => 'Delete ' . $row->name)
                        ->location(fn($row) => route('room.destroy', ['room' => $row->id]))
                        ->attributes(function($row) {
                            return [
                                'class' => 'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150',
                            ];
                        }),
                ]),
        ];
    }
}
