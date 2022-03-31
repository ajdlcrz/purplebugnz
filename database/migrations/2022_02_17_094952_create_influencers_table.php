<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('age');
            $table->string('sex');
            $table->string('contact_number');
            $table->json('content_category');
            $table->string('total_followers');
            $table->json('facebook'); // page_url | post_rate
            $table->json('instagram'); // page_url | post_rate | video_post_rate
            $table->json('youtube'); // page_url | post_rate
            $table->json('tiktok'); // page_url | post_rate
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
        Schema::dropIfExists('influencers');
    }
}
