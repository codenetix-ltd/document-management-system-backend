<?php

namespace App\Http\Requests;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class BulkApiRequest extends ApiRequest
{

    public function transformBulk(string $interface)
    {
        $rulesForOne = array_map( function($item){
            return trim($item, '*.');
        },array_filter(array_keys($this->rules())));

        $fields = array_diff($rulesForOne, $this->ignoredFields);

        $res = array_map(function($item)use($interface, $fields){
            $object = $this->container->make($interface);
            $itemData = [];
            foreach ($fields as $field) {
                if(isset($item[$field])) {
                    $itemData[$field] = $item[$field];
                }
            }
            $transformer = $this->getTransformer();

            $transformer->transform($itemData, $object);
            $this->updatedFields[] = $transformer->getTransformedFields();

            return $object;
        }, $this->json()->all());

        return $res;
    }

    public function rules()
    {
        $rules = parent::rules();
        $bulkRules = [
            '' => 'array'
        ];

        foreach($rules as $k => $v) {
            $bulkRules['*.'.$k] = $v;
        }

        return $bulkRules;
    }
}
