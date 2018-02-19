<?php

namespace App\Http\Controllers\API;

use App\Contracts\Services\Type\ITypeListService;
use App\Http\Controllers\Controller;
use App\Http\Resources\TypeResource;

class TypeController extends Controller
{
    //TODO - А надо ли вообще этот ендпоинт или мы можем строго описать допустимые типы аттрибутов в документации?
    public function index(ITypeListService $typeListService)
    {
        $users = $typeListService->list();

        return (TypeResource::collection($users))->response()->setStatusCode(200);
    }
}
