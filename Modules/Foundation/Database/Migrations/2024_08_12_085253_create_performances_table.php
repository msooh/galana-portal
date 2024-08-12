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
        Schema::create('performances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->enum('year', ['1', '2', '3', '4']); 
            $table->enum('term', ['1', '2', '3']); 
            $table->decimal('mid_mean_score', 5, 2);
            $table->string('mid_term_position')->nullable();
            $table->decimal('end_term_mean_score', 5, 2);
            $table->string('end_term_position')->nullable();
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
        Schema::dropIfExists('performance');
    }
};
