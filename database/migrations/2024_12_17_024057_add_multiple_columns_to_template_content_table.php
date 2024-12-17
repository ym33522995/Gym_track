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
        Schema::table('template_content', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('template_id');
            $table->unsignedBigInteger('exercise_id');
            $table->integer('order');
            $table->decimal('weight');
            $table->integer('rep');
            $table->integer('set');

            $table->foreign('template_id')->references('id')->on('template')->onDelete('cascade');
            $table->foreign('exercise_id')->references('id')->on('exercise')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_content', function (Blueprint $table) {
            //
            $table->dropForeign(['template_id', 'exercise_id']);
            $table->dropColumn(['template_id', 'exercise_id', 'order', 'weight', 'rep', 'set']);
        });
    }
};
