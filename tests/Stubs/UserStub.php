<?php

namespace Tests\Stubs;

use App\Entities\Template;
use App\Entities\User;
use Illuminate\Support\Collection;

/**
 * Class UserStub
 * @package Tests\Stubs
 *
 * @property User $model
 */
class UserStub extends AbstractStub
{
    private $templateIds = [];

    protected function buildModel($valuesToOverride = [], $persisted = false, $states = [])
    {
        parent::buildModel($valuesToOverride, $persisted, $states);

        $this->templateIds = factory(Template::class, 5)->create()->pluck('id')->toArray();

        if($persisted) {
            $this->model->templates()->sync($this->templateIds);
        }
    }

    /**
     * @return string
     */
    protected function getModelName()
    {
        return User::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest()
    {
        return [
            'email' => $this->model->email,
            'fullName' => $this->model->fullName,
            'templateIds' => $this->templateIds,
            'avatarId' => $this->model->avatar->getId(),
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse()
    {
        return [
            'fullName' => $this->model->fullName,
            'email' => $this->model->email,
            'templateIds' => $this->templateIds,
            'avatarId' => $this->model->avatar->getId(),
            'avatar' => [
                'name'=>$this->model->avatar->getOriginalName(),
                'url' => $this->model->avatar->getPath()
            ]
        ];
    }
}