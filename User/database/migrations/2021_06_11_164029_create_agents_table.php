<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users','id')->onDelete('SET NULL');
            $table->foreignId('token_id')->nullable()->constrained('personal_access_tokens','id')->onDelete('SET NULL');
            $table->string('language')->nullable();
            $table->string('device_type')->nullable();
            $table->string('platform')->nullable();
            $table->string('browser')->nullable();
            $table->string('is_desktop')->nullable();
            $table->string('is_phone')->nullable();
            $table->string('robot')->nullable();
            $table->string('is_robot')->nullable();
            $table->string('platform_version')->nullable();
            $table->string('browser_version')->nullable();
            $table->text('user_agent')->nullable();

            $table->unsignedBigInteger('hit')->default(0);

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
        Schema::dropIfExists('agents');
    }
}
