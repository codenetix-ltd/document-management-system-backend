<?php

namespace App\Repositories;

use App\QueryParams\IQueryParamsObject;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;

abstract class BaseRepository
{

    /**
     * @return Model
     */
    abstract protected function getInstance();

    /**
     * @return Builder
     */
    protected function getQuery(): Builder
    {
        return $this->getInstance()->newQuery();
    }

    /**
     * @param IQueryParamsObject $queryParamsObject Query params to apply for the result set.
     * @return LengthAwarePaginator
     */
    public function paginateList(IQueryParamsObject $queryParamsObject): LengthAwarePaginator
    {
        return $this->getInstance()->paginate();
    }

    /**
     * @param array $data Array representation of saving model.
     * @return Model|null
     */
    public function create(array $data): ? Model
    {
        $entry = $this->getInstance()->create($data);

        return $this->getInstance()->find($entry->id);
    }

    /**
     * @param array   $data Array representation of updating model.
     * @param integer $id   ID of updating model.
     * @return Model|null
     */
    public function update(array $data, int $id): ?Model
    {
        $this->getInstance()->findOrFail($id)->update($data);

        return $this->getInstance()->find($id);
    }

    /**
     * @param integer $id ID of finding model.
     * @return Model
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id): Model
    {
        return $this->getInstance()->findOrFail($id);
    }

    /**
     * @param array $whereClauses Array of parameters to filter result.
     * @return Model
     */
    public function findWhere(array $whereClauses): ?Model
    {
        return $this->getInstance()->where($whereClauses)->first();
    }

    /**
     * @param integer $id ID of deleting model.
     * @return boolean
     */
    public function delete(int $id): bool
    {
        return $this->getInstance()->where(['id' => $id])->delete();
    }

    /**
     * @return Collection Collection of all retrieved models from the database.
     */
    public function all(): Collection
    {
        return $this->getInstance()->all();
    }

    /**
     * Sync relations
     *
     * @param integer $id         ID of syncing model.
     * @param string  $relation   Relation of target model to sync with.
     * @param array   $attributes Relation attributes to sync.
     * @param boolean $detaching  Detach which not listed in $attributes param.
     * @return array
     */
    public function sync(int $id, string $relation, array $attributes, bool $detaching = true)
    {
        return $this->find($id)->{$relation}()->sync($attributes, $detaching);
    }
}
