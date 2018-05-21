<?php

namespace Tests\Stubs;


/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
interface StubInterface
{
    public function buildModel($valuesToOverride = [], $persisted = false);

    public function buildRequest();

    public function getModel();
}