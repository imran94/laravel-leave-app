<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLeavesTableAvailableColumnTypeToDecimals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->decimal('sickAvailed', $precision = 3, $scale = 1)->default(0)->change();
            $table->decimal('otherAvailed', $precision = 3, $scale = 1)->default(0)->change();
            $table->decimal('annualAvailed', $precision = 3, $scale = 1)->default(0)->change();
            $table->decimal('annualLeft', $precision = 3, $scale = 1)->default(0)->change();
            $table->decimal('sickLeft', $precision = 3, $scale = 1)->default(0)->change();
            $table->decimal('otherLeft', $precision = 3, $scale = 1)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->integer('sickAvailed')->default(0)->change();
            $table->integer('otherAvailed')->default(0)->change();
            $table->integer('annualAvailed')->default(0)->change();
            $table->integer('annualLeft')->default(0)->change();
            $table->integer('sickLeft')->default(0)->change();
            $table->integer('otherLeft')->default(0)->change();
        });
    }
}
