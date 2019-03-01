<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('resource_type')->default('image');
            $table->string('type')->default('upload');
            $table->bigInteger('version');
            $table->string('public_id')->index();
            $table->string('format');
            $table->boolean('featured')->default(0);
            $table->integer('post_id')->unsigned();
            $table->string('thumb_size_url')->nullable();
            $table->string('full_size_url')->nullable();
            $table->string('display_size_url')->nullable();
            $table->string('medium_size_url');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
