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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->enum('year', ['1', '2', '3', '4']);
            $table->decimal('total_fees', 10, 2);
            $table->decimal('term_one_fees', 10, 2);
            $table->decimal('term_two_fees', 10, 2);
            $table->decimal('term_three_fees', 10, 2);
            $table->enum('status', ['paid', 'unpaid']);
            $table->decimal('uniform_others_amount', 10, 2)->nullable();
            $table->string('mode_of_payment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fees');
    }
};
