<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pump_allocations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('pump_id');
            $table->unsignedBigInteger('attendant_id');
            $table->decimal('electric_meter_reading', 32, 2);
            $table->decimal('meter_reading', 32, 2);
            $table->decimal('cash_reading', 32, 2);
            $table->decimal('closing_electric_meter_reading', 32, 2)->nullable();
            $table->decimal('closing_meter_reading', 32, 2)->nullable();
            $table->decimal('closing_cash_reading', 32, 2)->nullable();
            $table->dateTime('started_time')->nullable();
            $table->dateTime('closed_time')->nullable();
            $table->unsignedBigInteger('closed_by')->nullable();
            $table->decimal('cash_sale_difference', 32, 2)->nullable();            
            $table->timestamps();

            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');
            $table->foreign('pump_id')->references('id')->on('pumps')->onDelete('cascade');
            $table->foreign('attendant_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('closed_by')->references('id')->on('users')->onDelete('cascade');
       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pump_allocations');
    }
};
