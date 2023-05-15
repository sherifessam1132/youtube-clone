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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('channel_id');
            $table->string('uid')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('processed')->default(false);
            $table->string('video_id')->nullable();
            $table->string('video_filename')->nullable();
            $table->enum('visiblity',['public','unlisted','private']);
            $table->boolean('allow_votes')->default(true);
            $table->integer('process_percentage')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('channel_id')
                  ->references('id')
                  ->on('channels')
                  ->cascadeOnDelete();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
};
