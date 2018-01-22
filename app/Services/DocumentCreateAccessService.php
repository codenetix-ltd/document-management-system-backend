<?php

namespace App\Services;

use App\Contracts\Models\IRole;
use App\Contracts\Models\IUser;
use App\Contracts\Services\IDocumentCreateAccessService;
use App\Factory;
use App\Template;

class DocumentCreateAccessService extends ADocumentAccessService implements IDocumentCreateAccessService
{
    private $user;

    public function __construct(IUser $user)
    {
        $this->user = $user;
    }

    public function getAvailableFactoriesIds(): array
    {
        $factoriesIds = [];

        $fullAccessExists = false;
        foreach ($this->user->roles as $role) {
            /** @var IRole $role */
            $ids = $role->permissions()->where('name', 'document_create_by_factory')->pluck('targeted_id')->toArray();
            $factoriesIds = array_merge($factoriesIds, $ids);
            if ($role->hasPermission('document_create_by_any_factory')) $fullAccessExists = true;
        }

        if ($fullAccessExists) return Factory::all()->pluck('id')->toArray();

        return $factoriesIds;
    }

    public function getAvailableTemplatesIds(): array
    {
        $templatesIds = [];

        $fullAccessExists = false;
        foreach ($this->user->roles as $role) {
            $ids = $role->permissions()->where('name', 'document_create_by_template')->pluck('targeted_id')->toArray();
            $templatesIds = array_merge($templatesIds, $ids);
            if ($role->hasPermission('document_create_by_any_template')) $fullAccessExists = true;
        }

        if ($fullAccessExists) return Template::all()->pluck('id')->toArray();

        return $templatesIds;
    }
}