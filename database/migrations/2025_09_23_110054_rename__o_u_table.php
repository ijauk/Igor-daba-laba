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
        Schema::rename('organizatioanal_units', 'organizational_units');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('organizational_units', 'organizatioanal_units');
    }
};
