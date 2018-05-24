<?php

namespace Tests\Feature;

use App\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\ApiTestCase;
use Tests\Stubs\FileStub;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class FileTest extends ApiTestCase
{
    public function testUpload()
    {
        Storage::fake('files');

        $response = $this->jsonRequestPostEntityWithSuccess('files', [
            'file' => UploadedFile::fake()->image('avatar.jpg')
        ]);
        ;
        $createdFile = File::find($response->decodeResponseJson()['id']);

        $fileStub = new FileStub([], true, [], $createdFile);

        $response->assertExactJson($fileStub->buildResponse());
    }
}
