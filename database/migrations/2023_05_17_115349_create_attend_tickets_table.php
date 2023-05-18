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
        Schema::create('attend_tickets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ticket_id')->unsigned()->index();
            $table->timestamp('start_time');
            $table->timestamp('close_time')->nullable();
            $table->string('start_location')->nullable();
            $table->string('end_location')->nullable();
            $table->timestamps();
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attend_tickets');
    }
};
