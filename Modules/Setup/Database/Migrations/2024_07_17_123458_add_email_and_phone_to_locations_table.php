<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailAndPhoneToLocationsTable extends Migration
{
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->string('email')->nullable()->after('name');
            $table->string('phone')->nullable()->after('email');
        });
    }

    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('phone');
        });
    }
}
