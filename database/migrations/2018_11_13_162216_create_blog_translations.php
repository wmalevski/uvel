<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('blog_id')->unsigned()->nullable();
            $table->integer('thumbnail_id')->unsigned();
            $table->string('title');
            $table->longText('excerpt');
            $table->longText('content');
            $table->string('locale')->index();
            $table->unique(['blog_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_translations');
    }
}
