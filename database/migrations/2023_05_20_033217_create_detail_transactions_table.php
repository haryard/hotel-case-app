<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('TransID');
            $table->foreign('TransID')->references('id')->on('transactions')->onDelete('cascade');
            $table->unsignedBigInteger('RoomID');
            $table->foreign('RoomID')->references('id')->on('rooms');
            $table->integer('Days');
            $table->decimal('SubTotalRoom');
            $table->decimal('ExtraCharges');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transactions');
    }
};
