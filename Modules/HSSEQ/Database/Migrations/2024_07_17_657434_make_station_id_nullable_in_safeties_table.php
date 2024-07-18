<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeStationIdNullableInSafetiesTable extends Migration
{
    public function up()
    {
        Schema::table('safeties', function (Blueprint $table) {
            $table->unsignedBigInteger('station_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('safeties', function (Blueprint $table) {
            $table->unsignedBigInteger('station_id')->nullable(false)->change();
        });
    }
}
