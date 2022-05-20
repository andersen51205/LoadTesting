<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddErrorRateAndResponseTimeToTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->float('response_time', 8, 2)->after('loops');
            $table->float('error_rate', 5, 2)->after('response_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->dropColumn('response_time');
            $table->dropColumn('error_rate');
        });
    }
}
