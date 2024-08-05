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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('buying_price', 32, 2)->nullable();
            $table->decimal('selling_price', 32, 2)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->date('buying_start_date')->nullable();
            $table->date('buying_end_date')->nullable();
            $table->date('selling_start_date')->nullable();
            $table->date('selling_end_date')->nullable();

            $table->foreign('site_id')->references('id')->on('stations')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_prices');
    }
};
