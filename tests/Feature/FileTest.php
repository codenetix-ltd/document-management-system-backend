<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\ApiTestCase;

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

        $this->assertJsonStructure($response, array_keys(config('models.File')));
    }
}
