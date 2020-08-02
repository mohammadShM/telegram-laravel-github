<?php

use App\Message;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('chat_id');
            $table->unsignedBigInteger('reply_message_id')->nullable();
            $table->unsignedBigInteger('forward_message_id')->nullable();
            $table->enum('state', Message::MESSAGE_STATES)
                ->default(Message::MESSAGE_STATE_PENDING);
            $table->unsignedInteger('views')->default(0);
            $table->text('body')->nullable();
            $table->boolean('info')->default(false);

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('sender_id')
                ->references('id')
                ->on('users');
            $table->foreign('chat_id')
                ->references('id')
                ->on('chats');
            $table->foreign('reply_message_id')
                ->references('id')
                ->on('messages');
            $table->foreign('forward_message_id')
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
        Schema::dropIfExists('messages');
    }
}
