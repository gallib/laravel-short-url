<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('shorturl_urls', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->unsigned()->after('expires_at');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
};
