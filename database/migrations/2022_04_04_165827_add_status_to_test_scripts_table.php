<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTestScriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_scripts', function (Blueprint $table) {
            if (!Schema::hasColumn('test_scripts', 'status')) {
                // 在test_scripts表新增測試時間欄位
                $table->integer('status')->default(0)->after('description');
            }
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
            $table->dropColumn('status');
        });
    }
}
