<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_post_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_post_id')->constrained('blogposts')->onDelete('cascade'); // jako obratiti paznju na l8 konvencije i protokole singula i pozivanja u modelu
            $table->foreignId('tag_id')->constrained('tags')->onDelete('cascade'); // jako obratiti paznju na l8 konvencije i protokole singula i pozivanja u modelu
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
        Schema::dropIfExists('blog_post_tag');
    }
}
