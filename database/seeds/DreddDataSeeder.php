<?php

use App\DocumentVersion;
use App\Type;
use App\User;
use Illuminate\Database\Seeder;

class DreddDataSeeder extends Seeder
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

        factory(Type::class)->create(['name' => 'String', 'machine_name' => 'string']);
        factory(Type::class)->create(['name' => 'Numeric', 'machine_name' => 'numeric']);
        factory(Type::class)->create(['name' => 'Boolean', 'machine_name' => 'boolean']);
        factory(Type::class)->create(['name' => 'Table', 'machine_name' => 'table']);
        factory(Type::class)->create(['name' => 'Value with deviations', 'machine_name' => 'value_with_deviations']);

        factory(DocumentVersion::class, 10)->create();
    }
}
