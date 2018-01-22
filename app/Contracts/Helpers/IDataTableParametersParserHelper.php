<?php

namespace App\Contracts\Helpers;

interface IDataTableParametersParserHelper
{
    public static function parseDateRange(string $key, array $columns);
    public static function parseSelect(string $key, array $columns);
    public static function parseTernarySelect(string $key, array $columns);
    public static function parseTextInput(string $key, array $columns);
}