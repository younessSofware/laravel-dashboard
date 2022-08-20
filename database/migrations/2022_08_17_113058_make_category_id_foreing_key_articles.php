<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeCategoryIdForeingKeyArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function(Blueprint $table){
            $table->foreignId('category_id')->references('id')->on('categories');
        });
    }
    public function down()
    {
        Schema::table('articles', function(Blueprint $table){
            $table->dropForeign(['category_id']);

        });

    }
}
