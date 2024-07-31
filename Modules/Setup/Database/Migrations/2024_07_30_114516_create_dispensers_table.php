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
        Schema::create('dispensers', function (Blueprint $table) {
            $table->id();
            $table->string('dispenser_name', 191);
            $table->unsignedBigInteger('site_id');
            $table->string('type', 191);
            $table->decimal('opening_electric_meter_reading', 32, 2);
            $table->decimal('cumulative_meter_reading', 32, 2);
            $table->decimal('cash_reading', 32, 2);
            $table->string('status', 191);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('pump_id')->nullable();
            
            $table->foreign('site_id')->references('id')->on('stations')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('dispenser_id')->references('id')->on('pumps')->onDelete('set null');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dispensers');
    }
};
