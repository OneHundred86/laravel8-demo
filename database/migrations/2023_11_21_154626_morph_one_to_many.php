<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MorphOneToMany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 一对多（多态）#
        // https://learnku.com/docs/laravel/10.x/eloquent-relationships/14889#6c38b1

        Schema::create("videos", function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("url");
        });

        Schema::create("comments", function (Blueprint $table) {
            $table->id();
            $table->string("content");
            $table->morphs("commentable");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("videos");
        Schema::drop("comments");
    }
}
