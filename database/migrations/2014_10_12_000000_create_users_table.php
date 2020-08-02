<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mobile', 13)->unique();
            $table->string('name', 150);
            $table->string('username', 20)->nullable()->unique();
            $table->string('password', 10)->nullable();
            $table->string('bio', 70)->nullable();
            $table->string('code', 4)->nullable();
            $table->timestamp('code_expiration')->nullable();
            $table->timestamp('last_seen')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
