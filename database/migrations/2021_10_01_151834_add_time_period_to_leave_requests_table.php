<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimePeriodToLeaveRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('leave_requests', 'time_period')) {
            Schema::table('leave_requests', function (Blueprint $table) {
                $table->string('time_period')->nullable();
                $table->string('joiningDate')->nullable()->change();
                $table->renameColumn('joiningDate', 'return_date');
                $table->renameColumn('attachement', 'attachment');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropColumn('time_period');
            $table->string('return_date')->nullable(false)->change();
            $table->renameColumn('return_date', 'joiningDate');
            $table->renameColumn('attachement', 'attachment');
        });
    }
}
