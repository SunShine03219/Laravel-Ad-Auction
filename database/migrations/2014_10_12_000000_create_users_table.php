<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(256);

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('email', 191)->unique()->nullable();
            $table->string('password')->nullable();

            $table->integer('country_id')->nullable();
            $table->string('mobile')->nullable();
            $table->enum('gender', ['male', 'female', 'third_gender'])->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->enum('photo_storage', ['s3', 'public'])->nullable();

            $table->enum('user_type', ['user', 'admin'])->nullable();
            //active_status 0:pending, 1:active, 2:block;
            $table->enum('active_status', [0, 1, 2])->nullable();
            //is_email_verified 0:unverified, 1:verified
            $table->enum('is_email_verified', [0, 1])->nullable();
            $table->string('activation_code')->nullable();
            //is_online => 0:offline, 1:online;
            $table->enum('is_online', [0, 1])->nullable();

            $table->timestamp('last_login')->nullable();
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
        Schema::drop('users');
    }
}
