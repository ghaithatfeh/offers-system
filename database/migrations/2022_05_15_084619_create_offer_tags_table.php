<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_tags', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('offer_id');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->primary(['offer_id', 'tag_id']);
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
        Schema::dropIfExists('offer_tags');
    }
};
