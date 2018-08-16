<?php

namespace App\Services\Comments;

interface IRepository
{
    /**
     * @return mixed
     */
    public function all();

    /**
     * @param integer $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param array   $data
     * @param integer $id
     * @return mixed
     */
    public function update(array $data, int $id);

    /**
     * @param integer $id
     * @return mixed
     */
    public function delete(int $id);
}
