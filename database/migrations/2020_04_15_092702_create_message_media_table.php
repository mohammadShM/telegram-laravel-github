<?php

use App\MessageMedia;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('message_id');
            $table->enum('type', MessageMedia::MEDIA_TYPES)
                ->default(MessageMedia::MEDIA_TYPE_FILE);
            $table->string('mime_type');
            $table->bigInteger('size');
            $table->string('thumbnail')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('message_id')
                ->references('id')
                ->on('messages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_media');
    }
}
