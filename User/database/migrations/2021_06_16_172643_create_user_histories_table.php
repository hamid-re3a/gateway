<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_histories', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('actor_id')->constrained('users');

            $table->string('first_name',100)->nullable();
            $table->string('last_name',100)->nullable();
            $table->string('username',100)->nullable();
            $table->string('phone_number',100)->nullable();
            $table->string('email',100)->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->timestamp('birthday')->nullable();
            $table->string('password')->nullable();
            $table->string('transaction_password')->nullable();

            $table->string('block_type')->nullable();
            $table->string('block_reason')->nullable();

            $table->string('avatar')->nullable();
            $table->string('passport_number')->nullable();

            $table->timestamp('email_verified_at')->nullable();

            $table->boolean('google2fa_enable')->nullable();
            $table->string('google2fa_secret')->nullable();

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
        Schema::dropIfExists('user_histories');
    }
}
