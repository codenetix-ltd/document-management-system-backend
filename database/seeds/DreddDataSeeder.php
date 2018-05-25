<?php

use App\Entities\Document;
use App\Entities\User;
use Illuminate\Database\Seeder;
use Tests\Stubs\AttributeWithTypeStringStub;
use Tests\Stubs\AttributeWithTypeTableStub;
use Tests\Stubs\DocumentStub;
use Tests\Stubs\DocumentVersionStub;
use Tests\Stubs\UserStub;

class DreddDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var User $user */
        $user = (new UserStub([], true))->getModel();

        new AttributeWithTypeStringStub([], true);
        new AttributeWithTypeTableStub([], true);

        for($i=0;$i<3;++$i) {
            /** @var Document $document */
            $document = (new DocumentStub(['owner_id' => $user->id], true))->getModel();

            for($j=0;$j<3;++$j) {
                (new DocumentVersionStub(['document_id' => $document->id, 'is_actual' => false], true));
            }

        }
    }
}
