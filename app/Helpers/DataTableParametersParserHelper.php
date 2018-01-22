<?php

namespace App\Helpers;

use App\Contracts\Helpers\IDataTableParametersParserHelper;
use App\Entity\DateRange;

/**
 * Class DataTableParametersParserHelper
 * @package App\Helpers
 */
class DataTableParametersParserHelper implements IDataTableParametersParserHelper
{
    /**
     * @param $key
     * @param array $columns
     * @return DateRange|null
     */
    public static function parseDateRange(string $key, array $columns)
    {
        foreach ($columns as $column) {
            if (!empty($column['data']) && $column['data'] == $key) {
                if (!empty($column['search']) && $column['search']['value'] != 'null') {
                    $value = explode('|', $column['search']['value']);
                    return new DateRange($value[0], $value[1]);
                }
            }
        }

        return null;
    }

    /**
     * @param $key
     * @param array $columns
     * @return array|null
     */
    public static function parseSelect(string $key, array $columns)
    {
        foreach ($columns as $column) {
            if (!empty($column['data']) && $column['data'] == $key) {
                if (!empty($column['search']) && $column['search']['value'] != 'null') {
                    $value = explode(',', $column['search']['value']);

                    return $value;
                }
            }
        }

        return null;
    }

    /**
     * @param $key
     * @param array $columns
     * @return array|null
     */
    public static function parseTernarySelect(string $key, array $columns)
    {
        foreach ($columns as $column) {
            if (!empty($column['data']) && $column['data'] == $key) {
                if (!empty($column['search']) && $column['search']['value'] != 'null') {
                    $value = filter_var($column['search']['value'], FILTER_VALIDATE_BOOLEAN);

                    return $value;
                }
            }
        }

        return null;
    }

    /**
     * @param $key
     * @param array $columns
     * @return null
     */
    public static function parseTextInput(string $key, array $columns)
    {
        foreach ($columns as $column) {
            if (!empty($column['data']) && $column['data'] == $key) {
                if (!empty($column['search']) && $column['search']['value'] != 'null') {
                    return $column['search']['value'];
                }
            }
        }

        return null;
    }

}