<?php

namespace App\Repositories;

use App\Entities\User;

/**
 * Class DocumentRepositoryEloquent.
 *
 */
class UserRepository extends BaseRepository
{

    /**
     * Override method
     * For setting user password
     *
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        /** @var User $model */
        $entry = $this->getInstance()->newInstance($data);

        // Save password manually because this field in not in fillable list
        $entry->password = $data['password'];
        $entry->save();

        return $this->getInstance()->find($entry->id);
    }

    /**
     * @return mixed
     */
    protected function getInstance()
    {
        return new User();
    }
}
