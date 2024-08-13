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
        Schema::table('students', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('guardian_phone');
            $table->unsignedInteger('age')->nullable()->after('photo');
            $table->enum('gender', ['male', 'female'])->after('age');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('photo');
            $table->dropColumn('age');
            $table->dropColumn('gender');
        });
    }
};
