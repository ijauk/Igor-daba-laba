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
        Schema::create('hiring_plan_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->text('description')->nullable();
            $table->decimal('quantity', 4, 2)->default(1.00);
            $table->date('target_date')->nullable();
            $table->foreignId('job_position_id')
                ->constrained('job_positions')
                ->cascadeOnDelete();
            $table->foreignId('hiring_plan_id')
                ->constrained('hiring_plans')
                ->cascadeOnDelete();
            $table->enum('status', ['planned', 'in_progress', 'hired', 'canceled'])
                ->default('planned');
            $table->text('notes')->nullable();
            // snapshoti koji čuva podatke u trenutku kreiranja stavke plana zapošljavanja ako se podaci promene u budućnosti, stavka plana ostaje nepromenjena
            $table->string('snap_name');
            $table->foreignId('snap_organizational_unit_id')
                ->constrained('organizational_units');
            $table->foreignId('snap_education_id')
                ->constrained('educations');
            $table->decimal('snap_coefficient', 6, 2)->nullable();

            $table->timestamps();
            // sprječava duplikate istog radnog mjesta u istom planu
            $table->unique(['hiring_plan_id', 'job_position_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('hiring_plan_items');
    }
};
