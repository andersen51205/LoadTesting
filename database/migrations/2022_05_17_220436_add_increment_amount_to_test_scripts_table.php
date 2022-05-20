<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIncrementAmountToTestScriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_scripts', function (Blueprint $table) {
            $table->boolean('is_incremental')->after('description');
            $table->integer('start_thread')->after('is_incremental');
            $table->integer('end_thread')->after('start_thread');
            $table->integer('increment_amount')->after('end_thread');
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
            $table->dropColumn('is_incremental');
            $table->dropColumn('start_thread');
            $table->dropColumn('end_thread');
            $table->dropColumn('increment_amount');
        });
    }
}
