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
        Schema::create('tanks', function (Blueprint $table) {
            $table->id();
            $table->string('tank_name');
            $table->unsignedBigInteger('site_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('capacity', 32, 2);
            $table->decimal('opening_dip_reading', 32, 2);
            $table->string('status');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->decimal('opening_stock_value', 32, 2)->nullable();
            $table->decimal('dip_reading_incremental', 32, 2)->nullable();
            
            $table->foreign('site_id')->references('id')->on('stations')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tanks');
    }
};
