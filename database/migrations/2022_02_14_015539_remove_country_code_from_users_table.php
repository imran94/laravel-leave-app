<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCountryCodeFromUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->dropForeign('fk_department_id');
            $table->dropColumn('countryCode');
            $table->foreign('designationId')->references('id')->on('designation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('departmentId')->references('id')->on('department')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }
}
