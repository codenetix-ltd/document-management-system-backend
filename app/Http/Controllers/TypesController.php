<?php

namespace App\Http\Controllers;

use App\Http\Resources\TypeResource;
use App\Services\TypeService;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class TypesController extends Controller
{
    /**
     * @var TypeService
     */
    protected $service;

    /**
     * TypesController constructor.
     * @param TypeService $service
     */
    public function __construct(TypeService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $types = $this->service->paginate();
        return TypeResource::collection($types);
    }
}
