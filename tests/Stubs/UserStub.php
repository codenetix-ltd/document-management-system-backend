<?php

namespace Tests\Stubs;

use App\Entities\Role;
use App\Entities\Template;
use App\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserStub
 * @property User $model
 */
class UserStub extends AbstractStub
{
    /** @var array $templateIds */
    private $templateIds = [];

    /** @var array $roleIds */
    private $roleIds = [];

    /**
     * @param array   $valuesToOverride
     * @param boolean $persisted
     * @param array   $states
     * @return void
     */
    protected function buildModel(array $valuesToOverride = [], bool $persisted = false, array $states = []): void
    {
        parent::buildModel($valuesToOverride, $persisted, $states);

        $this->templateIds = factory(Template::class, 5)->create()->pluck('id')->toArray();
        $this->roleIds = Role::all()->pluck('id')->toArray();

        if ($persisted) {
            $this->model->templates()->sync($this->templateIds);
            $this->model->roles()->sync($this->roleIds);
        }
    }

    /**
     * @param Model $model
     * @return void
     */
    protected function initiateByModel(Model $model): void
    {
        parent::initiateByModel($model);

        $this->templateIds = $this->model->templates->pluck('id')->toArray();
        $this->roleIds = $this->model->roles->pluck('id')->toArray();
    }


    /**
     * @return string
     */
    protected function getModelName(): string
    {
        return User::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest(): array
    {
        return [
            'email' => $this->model->email,
            'fullName' => $this->model->fullName,
            'templatesIds' => $this->templateIds,
            'rolesIds' => $this->roleIds,
            'avatarId' => $this->model->avatar->id,
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse(): array
    {
        return [
            'fullName' => $this->model->fullName,
            'email' => $this->model->email,
            'templatesIds' => $this->templateIds,
            'rolesIds' => $this->roleIds,
            'avatarId' => $this->model->avatar->id,
            'avatar' => (new FileStub([], true, [], $this->model->avatar))->buildResponse(),
        ];
    }
}
