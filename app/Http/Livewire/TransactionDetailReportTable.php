<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\DetailTransaction;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class TransactionDetailReportTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return DetailTransaction::query()
            ->with(['transaction', 'room'])
            ->select('detail_transactions.*')
            ->join('transactions', 'detail_transactions.TransID', '=', 'transactions.ID')
            ->join('rooms', 'detail_transactions.RoomID', '=', 'rooms.ID');
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
                ->sortable(),
            Column::make("Transaction Code", "transaction.TransCode")
                ->sortable(),
            Column::make("Start Date", "transaction.TransDate")
                ->sortable(),
            Column::make("End Date")
                ->label(
                    fn($row) => $this->calculateEndDate($row->transaction->pluck('TransDate')[0], $row->pluck('Days')[0])
                )
                ->sortable()
            ,
            Column::make("Room Type", "room.roomType.RoomType")
                ->sortable(),
            Column::make("Room Name", "room.RoomName")
                ->collapseOnTablet(),
            Column::make("Days Stay", "Days")
                ->collapseOnTablet(),
            Column::make("SubTotal Room Prices", "SubTotalRoom")
                ->collapseOnTablet(),
            Column::make("Extra Charges", "ExtraCharges")
                ->collapseOnTablet(),
            Column::make("Customer Name", "transaction.CustName")
                ->collapseOnTablet(),
            Column::make("Total Room Prices", "transaction.TotalRoomPrice")
                ->collapseOnTablet(),
            Column::make("Total Extra Charges", "transaction.TotalExtraCharge")
                ->collapseOnTablet(),
            Column::make("Total Prices", "transaction.FinalTotal")
                ->collapseOnTablet(),
        ];
    }

    public function calculateEndDate($transactionDate, $days)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $transactionDate);
        $endDate = clone $startDate; 
        $endDate->addDays($days);

        return $endDate->format('Y-m-d');
    }
}
