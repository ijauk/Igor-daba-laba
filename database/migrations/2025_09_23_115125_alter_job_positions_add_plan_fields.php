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
            // Broj jedinice iz PUU
            $table->string('unit_number')->nullable()->after('organizational_unit_id');

            // Podbroj radnog mjesta
            $table->unsignedInteger('job_subnumber')->nullable()->after('unit_number');

            // Podbroj izvršitelja
            $table->unsignedInteger('incumbent_subnumber')->nullable()->after('job_subnumber');

            // Broj izvršitelja (planirano)
            $table->unsignedInteger('headcount')->nullable()->after('incumbent_subnumber');

            // Posebni/ostali uvjeti i prednost pri zapošljavanju
            $table->text('special_requirements')->nullable()->after('description');
            $table->text('other_requirements')->nullable()->after('special_requirements');
            $table->text('hiring_preference')->nullable()->after('other_requirements');

            // Poslovi i radni zadaci (opis)
            $table->longText('duties')->nullable()->after('hiring_preference');

            // Planirani koeficijent
            $table->decimal('planned_coefficient', 6, 2)->nullable()->after('duties');

            // Indeksi za bržu pretragu
            $table->index('unit_number');
            $table->index('job_subnumber');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_positions', function (Blueprint $table) {
            // Drop indexe pa kolone (MySQL dopušta drop bez eksplicitnog imena indeksa jer je simple index)
            $table->dropIndex(['unit_number']);
            $table->dropIndex(['job_subnumber']);

            $table->dropColumn([
                'unit_number',
                'job_subnumber',
                'incumbent_subnumber',
                'headcount',
                'special_requirements',
                'other_requirements',
                'hiring_preference',
                'duties',
                'planned_coefficient',
            ]);
        });
    }
};
