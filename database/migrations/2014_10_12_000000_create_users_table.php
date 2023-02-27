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
            $table->id()->comment('id');
            $table->string('name', 20)->comment('이름');
            $table->string('nickname', 30)->comment('별명');
            $table->string('password')->comment('패스워드');
            $table->string('phone', 20)->comment('전화번호');
            $table->string('email', 100)->comment('이메일')->unique();
            $table->char('gender', 1)->nullable()->comment('성별');
            $table->rememberToken();
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
