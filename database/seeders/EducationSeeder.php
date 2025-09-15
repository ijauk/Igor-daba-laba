<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Education;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Education::updateOrCreate(

            [
                'title' => 'Osnovna škola'

            ],
            [

                'abbreviation' => 'OŠ',
                'level' => 'NKV',
                'remark' => 'Najniži nivo obrazovanja'

            ],

        );
        Education::updateOrCreate(

            [
                'title' => 'Srednja škola'

            ],
            [

                'abbreviation' => 'SŠ',
                'level' => 'KV',
                'remark' => 'Srednje obrazovanje'

            ],

        );
        Education::updateOrCreate(

            [
                'title' => 'Viša škola'

            ],
            [

                'abbreviation' => 'VŠ',
                'level' => 'VKV',
                'remark' => 'Više obrazovanje'

            ],

        );
        Education::updateOrCreate(

            [
                'title' => 'Fakultet'

            ],
            [

                'abbreviation' => 'VSS',
                'level' => 'VSS',
                'remark' => 'Visoko obrazovanje'

            ],

        );

    }
}
