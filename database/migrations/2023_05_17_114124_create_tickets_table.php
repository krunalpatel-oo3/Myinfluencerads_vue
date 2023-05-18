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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->text('descritpion')->nullable();
            $table->bigInteger('problem_id')->unsigned()->index();
            $table->bigInteger('machine_id')->unsigned()->index();
            $table->bigInteger('assign_id')->unsigned()->index()->nullable();
            $table->bigInteger('created_by')->unsigned()->index();
            $table->tinyInteger('status')->default(1)->comment('1="Open"
            2="Pending"
            3="On-hold"
            4="Solved"
            5="Re-open"');
            $table->timestamps();
            $table->foreign('problem_id')->references('id')->on('problems')->onDelete('cascade');
            $table->foreign('machine_id')->references('id')->on('machines')->onDelete('cascade');
            $table->foreign('assign_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
