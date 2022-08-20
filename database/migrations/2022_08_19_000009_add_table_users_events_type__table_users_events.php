<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableUsersEventsTypeTableUsersEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('table_users_events', function (Blueprint $table) {
            $table->string('table_users_events_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table_users_events', function (Blueprint $table) {
            $table->dropColumn('table_users_events_type');
        });
    }
}
