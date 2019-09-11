<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddExpiresAtToUrls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shorturl_urls', function ($table) {
            $table->dateTime('expires_at')->nullable()->after('counter');
        });
    }
}
