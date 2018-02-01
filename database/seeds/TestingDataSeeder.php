<?php

use App\Template;
use App\Type;
use App\User;
use Illuminate\Database\Seeder;

class TestingDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create admin user
        factory(User::class)->create([
            'full_name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin'),
        ]);

        //Create default templates
        factory(Template::class, 5)->create();

        //TODO - данные необходимые для функционирования системы вынести в отдельный сидер
        //Create types
        factory(Type::class)->create(['name' => 'String', 'machine_name' => 'string']);
        factory(Type::class)->create(['name' => 'Numeric', 'machine_name' => 'numeric']);
        factory(Type::class)->create(['name' => 'Boolean', 'machine_name' => 'boolean']);
        factory(Type::class)->create(['name' => 'Table', 'machine_name' => 'table']);
        factory(Type::class)->create(['name' => 'Value with deviations', 'machine_name' => 'value_with_deviations']);


//        for($i = 0; $i < 5; $i++){
//            $userId = \App\User::create([
//                'full_name' => $faker->unique()->name,
//                'email' => $faker->unique()->email,
//                'password' => bcrypt('admin'),
//            ])->id;
//
//            $templateId = \App\Template::create([
//                'name' => ucfirst($faker->unique()->words(2, true))
//            ])->id;
//
//            $documentId = \App\Document::create([
//                'name' => ucfirst($faker->unique()->words(2, true)),
//                'template_id' => $templateId,
//                'owner_id' => $userId
//            ])->id;
//
//            DB::table('document_factories')->insert([
//                'factory_id' => rand(1,12),
//                'document_id' => $documentId
//            ]);
//
//            \App\DocumentVersion::create([
//                'version_name' => 1,
//                'is_actual' => 1,
//                'document_id' => $documentId
//            ])->id;
//        }
//
//        $exist = Storage::exists('public/profile-default.png');
//        if (!$exist) {
//            $storagePath = Storage::disk('seed')->getDriver()->getAdapter()->getPathPrefix();
//            Storage::disk('public')->put('profile-default.png', fopen($storagePath.'images/profile-default.png', 'r+'));
//        }
    }
}
