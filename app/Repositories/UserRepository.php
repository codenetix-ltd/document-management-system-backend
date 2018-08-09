<?php

namespace App\Repositories;

use App\Entities\User;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Validator\Contracts\ValidatorInterface;

/**
 * Class DocumentRepositoryEloquent.
 *
 */
class UserRepositoryEloquent extends BaseRepository
{

    /**
     * Override method
     * For setting user password
     *
     * @param array $attributes
     *
     * @return mixed
     *
     */
    public function create(array $attributes)
    {
//        if (!is_null($this->validator)) {
//            // we should pass data that has been casts by the model
//            // to make sure data type are same because validator may need to use
//            // this data to compare with data that fetch from database.
//            if ($this->versionCompare($this->app->version(), "5.2.*", ">")) {
//                $attributes = $this->model->newInstance()->forceFill($attributes)->makeVisible($this->model->getHidden())->toArray();
//            } else {
//                $model = $this->model->newInstance()->forceFill($attributes);
//                $model->addVisible($this->model->getHidden());
//                $attributes = $model->toArray();
//            }
//
//            $this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_CREATE);
//        }

        /** @var User $model */
        $model = $this->getInstance()->newInstance($attributes);
        $model->password = $attributes['password'];
        $model->save();
        $this->resetModel();

        event(new RepositoryEntityCreated($this, $model));

        return $this->parserResult($model);
    }

    /**
     * @return mixed
     */
    protected function getInstance()
    {
        return new User();
    }
}
