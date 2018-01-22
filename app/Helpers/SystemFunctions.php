<?php

use App\Document;
use App\Helpers\Builders\AuthorizerFactory;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

function authorizeActionForDocument(string $permission, Document $document = null)
{
    try {
        $authorizer = AuthorizerFactory::make('document', $document);
        return $authorizer->authorize($permission);
    } catch (AccessDeniedHttpException $exception) {
        return false;
    }
}

function authorizeActionForUser(string $permission, \App\User $user = null)
{
    try {
        $authorizer = AuthorizerFactory::make('user', $user);
        return $authorizer->authorize($permission);
    } catch (AccessDeniedHttpException $exception) {
        return false;
    }
}


global $authorizer;

function has_permission($action)
{
    global $authorizer;

    if (!$authorizer) {
        $authorizer = AuthorizerFactory::make();
    }

    try {
        return $authorizer->authorize($action);
    } catch (AccessDeniedHttpException $exception) {
        return false;
    }
}

function get_export_format_by_value($value)
{
    $parts = explode('.', $value);

    if (count($parts) == 1) {
        return '';
    } else {
        $format = '0.';
        $length = strlen($parts[1]);
        for ($i = 0; $i < $length; $i++) {
            $format .= '0';
        }

        return $format;
    }
}