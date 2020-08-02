<?php

use App\ChatOptions;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chat_id');
            $table->string('name', 50)->nullable();
            $table->string('description', 150)->nullable();
            $table->text('photos')->nullable();
            $table->enum('scope', ChatOptions::CHAT_SCOPES)->nullable();
            $table->string('link',40)->nullable();
            $table->boolean('sign_messages')->default(false);
            $table->boolean('show_chat_history')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('chat_id')
                ->references('id')
                ->on('chats')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_options');
    }
}
