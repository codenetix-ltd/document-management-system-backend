<?php

namespace Tests\Feature;

use App\Entities\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Stubs\FileStub;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class FileTest extends TestCase
{
    /**
     * Setup the test environment.
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->actingAs($this->authUser);
    }

    /**
     * Upload file
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testUpload()
    {
        Storage::fake('files');
        UploadedFile::fake()->image('avatar.jpg');

        $response = $this->json('POST', self::API_ROOT . 'files', [
            'file' => UploadedFile::fake()->image('avatar.jpg')
        ]);
        $createdFile = File::find($response->decodeResponseJson()['id']);

        $fileStub = new FileStub([], true, [], $createdFile);

        $response->assertExactJson($fileStub->buildResponse());
    }
}
