<?php

namespace Tests\Feature;

use App\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Stubs\FileStub;
use Tests\TestCase;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class FileTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();
        $this->actingAs($this->authUser);
    }

    public function testUpload()
    {
        Storage::fake('files');
        UploadedFile::fake()->image('avatar.jpg');

        $response = $this->json('POST', 'api/files', [
            'file' => UploadedFile::fake()->image('avatar.jpg')
        ]);
        $createdFile = File::find($response->decodeResponseJson()['id']);

        $fileStub = new FileStub([], true, [], $createdFile);

        $response->assertExactJson($fileStub->buildResponse());
    }
}
