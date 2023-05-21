<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\DetailTransaction;

class TransactionDetailUserTable extends DataTableComponent
{
    public function builder(): Builder
    {
        $transID = request()->route('transaction.id');

        return DetailTransaction::query()
            ->with(['transaction', 'room', 'extras'])
            ->select('detail_transactions.*')
            ->join('transactions', 'detail_transactions.TransID', '=', 'transactions.ID')
            ->join('rooms', 'detail_transactions.RoomID', '=', 'rooms.ID')
            ->leftJoin('extras', 'detail_transactions.id', '=', 'extras.DetailTransID')
            ->where('detail_transactions.TransID', $transID);
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
            Column::make("Id", "id")
                ->sortable()
                ->hideIf(true),
            Column::make("TransID", "TransID")
                ->sortable()
                ->hideIf(true),
            Column::make("Room", "room.RoomName")
                ->sortable(),
            Column::make("Room Type", "room.roomType.RoomType")
                ->sortable(),
            Column::make("Days Stay", "Days")
                ->sortable(),
            Column::make("Sub Total Room Price", "SubTotalRoom")
                ->sortable()
                ->collapseOnTablet(),
            Column::make("Extra Charges", "ExtraCharges")
                ->sortable()
                ->collapseOnTablet(),
        ];
    }
}
