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
        Schema::create('fortles_node_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fortles_node_structure_id')->constrained();
            $table->text('error')->nullable();
            $table->integer('created')->unsigned()->default(0);
            $table->integer('updated')->unsigned()->default(0);
            $table->integer('deleted')->unsigned()->default(0);
            $table->integer('skipped')->unsigned()->default(0);
            $table->dateTime('started_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('ended_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fortles_node_logs');
    }
};
