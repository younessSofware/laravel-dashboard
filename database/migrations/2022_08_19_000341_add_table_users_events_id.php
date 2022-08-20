<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableUsersEventsId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('table_users_events', function (Blueprint $table) {
            $table->foreignId('table_users_events_id')->references('id')->on('events');

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
            $table->dropForeign('table_users_events_id');
        });
    }
}
