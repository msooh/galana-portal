<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherLocationIdToSafetiesTable extends Migration
{
    public function up()
    {
        Schema::table('safeties', function (Blueprint $table) {
            $table->unsignedBigInteger('other_location_id')->nullable()->after('station_id');
            $table->foreign('other_location_id')->references('id')->on('locations')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('safeties', function (Blueprint $table) {
            $table->dropForeign(['other_location_id']);
            $table->dropColumn('other_location_id');
        });
    }
}
