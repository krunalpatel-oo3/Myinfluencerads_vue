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
        Schema::create('ticket_media', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ticket_id')->unsigned()->index();
            $table->string('photo')->nullable();
            $table->string('audio')->nullable();
            $table->string('video')->nullable();
            $table->timestamps();
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_media');
    }
};
