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
        Schema::table('record_exercise', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('record_id');
            $table->unsignedBigInteger('exercise_id');
            $table->decimal('weight');
            $table->integer('rep');
            $table->text('notes')->nullable();

            $table->foreign('record_id')->references('id')->on('record')->onDelete('cascade');
            $table->foreign('exercise_id')->references('id')->on('exercise')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('record_exercise', function (Blueprint $table) {
            //
            $table->dropForeign(['record_id', 'exercise_id']);
            $table->dropColumn(['record_id', 'exercise_id', 'weight', 'rep', 'notes']);
        });
    }
};
