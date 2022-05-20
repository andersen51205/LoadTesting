<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteStartAndEndTimeFromTestScriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_scripts', function (Blueprint $table) {
            $table->dropColumn('start_at');
            $table->dropColumn('end_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_scripts', function (Blueprint $table) {
            $table->dateTime('start_at')->nullable()->after('description');
            $table->dateTime('end_at')->nullable()->after('start_at');
        });
    }
}
