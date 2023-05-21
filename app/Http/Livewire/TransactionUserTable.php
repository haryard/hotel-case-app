<?php

namespace App\Http\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class TransactionUserTable extends DataTableComponent
{
    protected $model = Transaction::class;

    public function builder(): Builder
    {
        $userId = Auth::id(); // Mendapatkan user_id pengguna yang login

        return Transaction::query()
            ->where('UserID', $userId);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setEagerLoadAllRelationsEnabled();
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
                ->sortable()
                ->hideIf(true),
            Column::make("Transaction Code", "TransCode")
                ->sortable(),
            Column::make("Transaction Date", "TransDate")
                ->sortable()
                ->collapseOnTablet(),
            Column::make("Customer Name", "CustName")
                ->sortable()
                ->collapseOnTablet(),
            Column::make("Total Room Price", "TotalRoomPrice")
                ->sortable()
                ->collapseOnTablet(),
            Column::make("Total Extra Charge", "TotalExtraCharge")
                ->sortable()
                ->collapseOnTablet(),
            Column::make("Total Prices", "FinalTotal")
                ->sortable(),
            ButtonGroupColumn::make('Actions')
                ->attributes(function($row) {
                    return [
                        'class' => 'space-x-2',
                    ];
                })
                ->buttons([
                    LinkColumn::make('View')
                        ->title(fn($row) => 'View' . $row->name)
                        ->location(fn($row) => route('reservation.show', ['transaction' => $row->id]))
                        ->attributes(function($row) {
                            return [
                                'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150',
                            ];
                        }),
                        LinkColumn::make('Delete')
                        ->title(fn($row) => 'Delete ' . $row->name)
                        ->location(fn($row) => route('reservation.destroy', ['transaction' => $row->id]))
                        ->attributes(function($row) {
                            return [
                                'class' => 'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150',
                            ];
                        }),
                ])
        ];
    }
}
