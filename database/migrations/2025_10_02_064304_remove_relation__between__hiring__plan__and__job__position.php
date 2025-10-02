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
            $table->dropForeign(['hiring_plan_id']);
            $table->dropColumn('hiring_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hiring_plan_items', function (Blueprint $table) {
            $table->unsignedBigInteger('hiring_plan_id')->nullable();
            $table->foreign('hiring_plan_id')->references('id')->on('hiring_plans')->onDelete('cascade');
        });
    }
    
};
