<?php

namespace Tests\Feature;

use Tests\ApiTestCase;

class TypeTest extends ApiTestCase
{
    private const PATH = 'types';

    public function testListOfTemplatesWithPaginationSuccess()
    {
        $this->jsonRequestObjectsWithPagination(self::PATH);
    }
}
