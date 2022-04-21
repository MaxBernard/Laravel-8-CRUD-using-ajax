<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->bigInteger('author_id')->unsigned();
        $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        $table->string('title', 128)->nullable();
        $table->string('slug', 128)->nullable();
        $table->mediumText('content')->nullable();
        $table->integer('category');
        $table->integer('tag');
        $table->string('cover_image', 64)->nullable();
        $table->boolean('public')->default(true);
        $table->integer('year');
        $table->integer('month');
        $table->datetime('published_at')->nullable();
        $table->index('title');
        $table->softDeletes();
        $table->timestamps();
    });
  }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
