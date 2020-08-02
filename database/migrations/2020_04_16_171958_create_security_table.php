<?php

use App\Security;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecurityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->text('blocked_users')->nullable();
            $table->enum('share_phone_number', Security::ACCESS_LEVELS)
                ->default(Security::ACCESS_LEVEL_EVERYONE);
            $table->text('share_phone_number_exceptions')->nullable();
            $table->enum('last_seen', Security::ACCESS_LEVELS)
                ->default(Security::ACCESS_LEVEL_EVERYONE);
            $table->text('last_seen_exceptions')->nullable();
            $table->enum('forward_message', Security::ACCESS_LEVELS)
                ->default(Security::ACCESS_LEVEL_EVERYONE);
            $table->text('forward_message_exceptions')->nullable();
            $table->enum('profile_photo', Security::ACCESS_LEVELS)
                ->default(Security::ACCESS_LEVEL_EVERYONE);
            $table->text('profile_photo_exceptions')->nullable();
            $table->enum('add_to_groups', Security::ACCESS_LEVELS)
                ->default(Security::ACCESS_LEVEL_EVERYONE);
            $table->text('add_to_groups_exceptions')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('security');
    }
}
