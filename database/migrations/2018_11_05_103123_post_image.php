<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PostImage extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create(
            'post_image', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned();;
            $table->text('filename');
            $table->timestamps();
            $table->foreign('post_id')->references('id')->on('post')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('post_image');
    }
}
