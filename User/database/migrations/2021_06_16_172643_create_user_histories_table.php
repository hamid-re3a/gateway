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
            $table->unsignedBigInteger('member_id')->nullable();

            $table->string('first_name',100);
            $table->string('last_name',100);
            $table->string('username',100)->nullable();
            $table->string('mobile_number',100)->nullable();
            $table->string('landline_number',100)->nullable();
            $table->mediumText('address_line1')->nullable();
            $table->mediumText('address_line2')->nullable();
            $table->string('email',100)->nullable()->index();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->timestamp('birthday')->nullable();
            $table->string('password');
            $table->string('transaction_password')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->foreignId('city_id')->nullable()->constrained('cities');
            $table->foreignId('state_id')->nullable()->constrained('cities','id');

            $table->string('block_type')->nullable();
            $table->string('block_reason')->nullable();

            $table->json('avatar')->nullable();
            $table->string('passport_number')->nullable();

            $table->timestamp('email_verified_at')->nullable();

            $table->boolean('google2fa_enable')->default(false);
            $table->string('google2fa_secret')->nullable();

            $table->boolean('is_freeze')->default(FALSE);
            $table->boolean('is_deactivate')->default(FALSE);


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
