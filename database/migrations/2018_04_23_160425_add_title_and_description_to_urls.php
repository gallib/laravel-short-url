<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddTitleAndDescriptionToUrls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shorturl_urls', function ($table) {
            $table->string('title')->nullable()->after('code');
            $table->text('description')->nullable()->after('title');
        });
    }
}
