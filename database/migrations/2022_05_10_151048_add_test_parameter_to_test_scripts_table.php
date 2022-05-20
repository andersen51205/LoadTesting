<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTestParameterToTestScriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_scripts', function (Blueprint $table) {
            $table->integer('threads')->after('description');
            $table->integer('ramp_up_period')->after('threads');
            $table->integer('loops')->after('ramp_up_period');
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
            $table->dropColumn('threads');
            $table->dropColumn('ramp_up_period');
            $table->dropColumn('loops');
        });
    }
}
