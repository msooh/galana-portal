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
        Schema::create('safeties', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Accident', 'Incident']);            
            $table->date('date');
            $table->time('time');
            $table->text('comment');
            $table->text('action');            
            $table->integer('slightly_injured')->nullable();
            $table->integer('injured_medical_treatment')->nullable();
            $table->integer('injured_hospitalization')->nullable();
            $table->integer('fatalities')->nullable();
            $table->text('other_details')->nullable();
            $table->enum('police_report', ['YES', 'NO'])->default('NO');
            $table->string('police_file')->nullable();
            $table->enum('status', ['pending', 'In-Progress', 'Closed'])->default('pending');
            $table->string('notes')->nullable();
            $table->unsignedBigInteger('station_id');
            $table->unsignedBigInteger('accident_type_id')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->timestamp('assigned_at')->nullable();           
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable(); 
            $table->timestamps();            
           
            $table->foreign('accident_type_id')->references('id')->on('accident_types')->onDelete('set null');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->foreign('station_id')->references('id')->on('stations')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('safeties');
    }
};
