<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeResource;
use App\Services\Type\TypeService;

class TypeController extends Controller
{
    //TODO - А надо ли вообще этот ендпоинт или мы можем строго описать допустимые типы аттрибутов в документации?
    public function index(TypeService $typeListService)
    {
        $users = $typeListService->list();

        return (TypeResource::collection($users))->response()->setStatusCode(200);
    }
}
