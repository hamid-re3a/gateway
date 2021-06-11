<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailAndTextSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_and_text_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('subject');
            $table->string('from');
            $table->string('from_name');
            $table->longText('body');
            $table->integer('variables_number');
            $table->text('variables_description');
            $table->string('type');
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
        Schema::dropIfExists('email_and_text_settings');
    }
}
