<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveEmailContentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_content_settings', function (Blueprint $table) {
            $table->boolean('is_active')->nullable()->default(true)->after('key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('email_content_settings', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
}
