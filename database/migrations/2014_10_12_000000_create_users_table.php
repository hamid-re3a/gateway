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
            $table->engine = "InnoDB";
            $table->id();

            $table->string('first_name',100);
            $table->string('last_name',100);
            $table->string('username',100)->nullable()->unique();
            $table->string('phone_number',100)->nullable();
            $table->string('email',100)->unique()->index();
            $table->string('password');
            $table->string('transaction_password')->nullable();

            $table->string('avatar')->nullable();

            $table->string('passport_number')->nullable();
            $table->boolean('is_passport_number_accepted')->nullable();
            $table->string('national_id')->nullable();
            $table->boolean('is_national_id_accepted')->nullable();
            $table->string('driving_licence')->nullable();
            $table->boolean('is_driving_licence_accepted')->nullable();


            $table->timestamps();
            $table->softDeletes();
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
