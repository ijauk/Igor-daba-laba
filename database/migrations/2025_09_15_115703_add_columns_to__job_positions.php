<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('job_positions', function (Blueprint $table) {

            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('min_salary', 10, 2)->nullable();
            $table->decimal('max_salary', 10, 2)->nullable();
            $table->boolean('is_active')->default(true);

            // --- IGNORE ---
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('j
        ob_positions', function (Blueprint $table) {
            $table->dropColumn(['name', 'min_salary', 'max_salary', 'is_active']);
        });
    }
};
