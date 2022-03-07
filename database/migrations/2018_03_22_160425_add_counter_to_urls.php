<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shorturl_urls', function ($table) {
            $table->unsignedInteger('counter')->default(0)->after('code');
        });
    }
};
