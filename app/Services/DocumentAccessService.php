<?php

namespace App\Services;

use App\Contracts\Models\IDocument;
use App\Contracts\Models\IRole;
use App\Contracts\Models\IUser;
use App\Contracts\Services\IDocumentAccessService;
use App\Factory;
use App\Template;

class DocumentAccessService extends ADocumentAccessService implements IDocumentAccessService
{
    private $user;

    private $document;

    public function __construct(IUser $user, IDocument $document)
    {
        $this->user = $user;
        $this->document = $document;
    }

    public function getAvailableFactoriesIds(): array
    {
        $factoriesIds = [];

        $fullAccessExists = false;
        foreach ($this->user->roles as $role) {
            /** @var IRole $role */
            $ids = $role->permissions()->where('name', 'document_update_by_factory')->pluck('targeted_id')->toArray();
            $factoriesIds = array_merge($factoriesIds, $ids);
            if ($role->hasPermission('document_update_by_any_factory')) $fullAccessExists = true;
        }

        if ($this->document) {
            $factoriesIds = array_merge($factoriesIds, $this->document->factories->pluck('id')->toArray());
        }

        if ($fullAccessExists) return Factory::all()->pluck('id')->toArray();

        return $factoriesIds;
    }

    public function getAvailableTemplatesIds(): array
    {
        $templatesIds = [];

        $fullAccessExists = false;
        foreach ($this->user->roles as $role) {
            $ids = $role->permissions()->where('name' ,'document_update_by_template')->pluck('targeted_id')->toArray();
            $templatesIds = array_merge($templatesIds, $ids);
            if ($role->hasPermission('document_update_by_any_template')) $fullAccessExists = true;
        }

        if ($this->document) {
            $templatesIds = array_merge($templatesIds, [$this->document->template->id]);
        }

        if ($fullAccessExists) return Template::all()->pluck('id')->toArray();

        return $templatesIds;
    }
}