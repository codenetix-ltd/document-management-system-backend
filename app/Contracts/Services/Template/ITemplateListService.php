<?php

namespace App\Contracts\Services\Template;

use App\Contracts\Repositories\ITemplateRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

interface ITemplateListService
{
    public function __construct(ITemplateRepository $repository);

    //TODO - вынести в родительский класс
    public function list(): LengthAwarePaginatorContract;
}