<?php

use App\Label;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Ticket;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('users')->insert([
            'full_name' => 'Andrei Vorobyev',
            'email' => 'admin@email.com',
            'password' => bcrypt('admin'),
        ]);

        DB::table('types')->insert([
            'name' => 'String',
            'machine_name' => 'string'
        ]);
        DB::table('types')->insert([
            'name' => 'Numeric',
            'machine_name' => 'numeric'
        ]);
        DB::table('types')->insert([
            'name' => 'Boolean',
            'machine_name' => 'boolean'
        ]);
        DB::table('types')->insert([
            'name' => 'Table',
            'machine_name' => 'table'
        ]);

        DB::table('types')->insert([
            'name' => 'Value with deviations',
            'machine_name' => 'value_with_deviations'
        ]);

        $factories = [
            1 => 'RĪGAS PIENA KOMBINĀTS, LATVIA',
            2 => 'VALMIERAS PIENS, LATVIA',
            3 => 'RIGAS PIENSAIMNIEKS, LATVIA',
            4 => 'PREMIA, ESTONIA',
            5 => 'PREMIA KPC, LITHUANIA',
            6 => 'RUSSIA MAIN OFFICE',
            7 => 'HLADOKOMBINAT №1, RUSSIA',
            8 => 'INGMAN ICE CREAM, REPUBLIC OF BELARUS',
            9 => 'PREMIER IS, DENMARK',
            10 => 'ISBJORN IS, NORWAY',
            11 => 'ALPIN57LUX, ROMANIA',
            12 => 'CHINA',
            13 => 'NETHERLANDS'
        ];

        foreach ($factories as $factory) {
            DB::table('factories')->insert([
                'name' => $factory
            ]);
        }

        $tags = [
            'test tag',
            'test tag 2'
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'name' => $tag
            ]);
        }

        $labels = [
            'Classic',
            'Curved'
        ];
        foreach ($labels as $labelName) {
            $label = new Label();
            $label->name = $labelName;
            $label->save();
        }

        for($i = 0; $i < 5; $i++){
            $userId = \App\User::create([
                'full_name' => $faker->unique()->name,
                'email' => $faker->unique()->email,
                'password' => bcrypt('admin'),
            ])->id;

            $templateId = \App\Template::create([
                'name' => ucfirst($faker->unique()->words(2, true))
            ])->id;

            $documentId = \App\Document::create([
                'name' => ucfirst($faker->unique()->words(2, true)),
                'template_id' => $templateId,
                'owner_id' => $userId
            ])->id;

            DB::table('document_factories')->insert([
                'factory_id' => rand(1,12),
                'document_id' => $documentId
            ]);

            \App\DocumentVersion::create([
                'version_name' => 1,
                'is_actual' => 1,
                'document_id' => $documentId
            ])->id;
        }

        $exist = Storage::exists('public/profile-default.png');
        if (!$exist) {
            $storagePath = Storage::disk('seed')->getDriver()->getAdapter()->getPathPrefix();
            Storage::disk('public')->put('profile-default.png', fopen($storagePath.'images/profile-default.png', 'r+'));
        }
    }
}
