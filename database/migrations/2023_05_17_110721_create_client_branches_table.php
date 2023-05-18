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
        Schema::create('client_branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('client_id')->unsigned()->index()->nullable();
            $table->tinyInteger('status')->default(1)->comment('0="In-active", 1= "Active"');
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('client')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_branches');
    }
};
