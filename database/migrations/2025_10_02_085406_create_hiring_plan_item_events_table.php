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
        Schema::create('hiring_plan_item_events', function (Blueprint $table) {
            $table->id();
            $table->text('event');
            $table->foreignId('hiring_plan_item_id')->constrained()->onDelete('cascade');
            $table->enum('severity', ['info', 'warning', 'error'])->default('info');
            // Evidencija korisnika
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hiring_plan_item_events');
    }
};
