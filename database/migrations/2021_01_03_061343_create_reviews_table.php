<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->uuid('review_id');
            $table->foreignId('user_id')->index();
            $table->foreignId('product_id')->index();
            $table->text('content')->nullable();
            $table->unsignedTinyInteger('rating');
            $table->timestamps();
            $table->index(['user_id', 'product_id'], 'review_user_id_product_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
