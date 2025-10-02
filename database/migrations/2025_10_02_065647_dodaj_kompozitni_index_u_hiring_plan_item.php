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
        Schema::table('hiring_plan_items', function (Blueprint $table) {
            $table->foreignId('hiring_plan_id')->constrained()->cascadeOnDelete();
            $table->unique(['hiring_plan_id', 'job_position_id'], 'unique_hiring_plan_job_position_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hiring_plan_items', function (Blueprint $table) {
            $table->dropUnique('unique_hiring_plan_job_position_index');
            $table->dropForeign(['hiring_plan_id']);
        });
    }
};
