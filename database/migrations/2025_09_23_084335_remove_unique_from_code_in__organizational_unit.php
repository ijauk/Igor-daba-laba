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
        Schema::table('organizatioanal_units', function (Blueprint $table) {
            $table->dropUnique(['code']); // makni unique constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizatioanal_units', function (Blueprint $table) {
            $table->unique('code'); // ako vraćam unazad, vrati unique constraint
        });
    }
};
