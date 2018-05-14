<?php

namespace App\Services\Authorizers;

use App\Context\BlankAuthorizeContext;
use App\Handlers\Permissions\ABlankPermissionHandler;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserBlankAuthorizer extends AAuthorizer
{
    private $context;

    public function __construct(BlankAuthorizeContext $blankAuthorizeContext)
    {
        $this->context = $blankAuthorizeContext;
    }

    public function authorize($permission)
    {
        $permission = 'user.' . $permission;

        $handlerClasses = $this->getHandlerClasses($permission);
        foreach ($handlerClasses as $handlerClass) {
            /** @var ABlankPermissionHandler $handlerInstance */
            $handlerInstance = new $handlerClass();
            if ($handlerInstance->handle($this->context)) {
                return;
            }
        }

        throw new AccessDeniedHttpException('You don\'t have enough rights to perform this operation');
    }
}