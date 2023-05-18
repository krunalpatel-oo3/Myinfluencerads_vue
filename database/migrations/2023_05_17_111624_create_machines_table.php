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
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('assign_id')->unsigned()->index()->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0="In-active", 1= "Active"');
            $table->tinyInteger('amc_status')->nullable();
            $table->decimal('amc_price', 10, 2)->nullable();
            $table->timestamps();
            $table->foreign('assign_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
