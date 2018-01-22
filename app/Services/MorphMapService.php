<?php

namespace App\Services;

use App\Contracts\Services\IMorphMapService;

class MorphMapService implements IMorphMapService
{
    public function getList(): array
    {
        $list = [];
        foreach (config('system.morphMap') as $entityKey => $entity) {
            $list[] = [
                'id' => $entityKey,
                'name' => $entityKey
            ];
        }

        return $list;
    }
}