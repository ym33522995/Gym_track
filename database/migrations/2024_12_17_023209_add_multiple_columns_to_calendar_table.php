<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('calendar', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('record_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('record_id')->references('id')->on('record')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calendar', function (Blueprint $table) {
            //
            $table->dropForeign(['user_id', 'record_id']);
            $table->dropColumn(['user_id', 'record_id']);
        });
    }
};
