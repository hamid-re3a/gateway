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
            $table->string('username',100)->unique();
            $table->string('phone_number',100)->nullable();
            $table->string('email',100)->unique()->index();
            $table->string('password');
            $table->string('transaction_password')->nullable();

            $table->string('avatar')->nullable();

            $table->string('passport_number')->nullable();

            $table->string('otp')->nullable();
            $table->timestamp('otp_datetime')->nullable();
            $table->integer('otp_tries')->nullable();

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
