<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('checklist_item_id');            
            $table->unsignedBigInteger('survey_id');
            $table->string('response');  
            $table->string('file_path')->nullable();         
            $table->timestamps();

            $table->foreign('checklist_item_id')->references('id')->on('checklists')->onDelete('cascade');            
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responses');
    }
};
