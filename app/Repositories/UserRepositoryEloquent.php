<?php

namespace App\Repositories;

use App\Entities\User;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class DocumentRepositoryEloquent.
 *
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Override method
     * @see BaseRepository::create()
     * For setting user password
     *
     * @param array $attributes
     *
     * @return mixed
     *
     * @throws RepositoryException
     * @throws ValidatorException
     */
    public function create(array $attributes)
    {
        if (!is_null($this->validator)) {
            // we should pass data that has been casts by the model
            // to make sure data type are same because validator may need to use
            // this data to compare with data that fetch from database.
            if ($this->versionCompare($this->app->version(), "5.2.*", ">")) {
                $attributes = $this->model->newInstance()->forceFill($attributes)->makeVisible($this->model->getHidden())->toArray();
            } else {
                $model = $this->model->newInstance()->forceFill($attributes);
                $model->addVisible($this->model->getHidden());
                $attributes = $model->toArray();
            }

            $this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_CREATE);
        }

        /** @var User $model */
        $model = $this->model->newInstance($attributes);
        $model->password = $attributes['password'];
        $model->save();
        $this->resetModel();

        event(new RepositoryEntityCreated($this, $model));

        return $this->parserResult($model);
    }
}
