<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Morph1to1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 一对一 (多态)
        // https://learnku.com/docs/laravel/10.x/eloquent-relationships/14889#35d89d

        Schema::create("posts", function (Blueprint $table){
            $table->id();
            $table->string("title");
            $table->mediumText("content");
        });

        Schema::create("images", function (Blueprint $table){
            $table->id();
            $table->string("url");
            $table->morphs("imageable");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("posts");
        Schema::drop("images");
    }
}
