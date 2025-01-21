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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('event_title')->comment('Event Title');
            $table->string('event_body')->nullable()->comment('Event Body');
            $table->date('start_date')->comment('start date');
            $table->date('end_date')->comment('end date');
            $table->string('event_color')->comment('event color');
            $table->string('event_border_color')->comment('event border color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
