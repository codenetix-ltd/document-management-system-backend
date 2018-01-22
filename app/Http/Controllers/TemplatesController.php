<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Contracts\CommandInvokers\IAtomCommandInvoker;
use App\Contracts\CommandInvokers\ITransactionCommandInvoker;
use App\Contracts\Commands\Paginators\ITemplatePaginatorCommand;
use App\Contracts\Commands\Template\ITemplateCreateCommand;
use App\Contracts\Commands\Template\ITemplateDeleteCommand;
use App\Contracts\Commands\Template\ITemplateGetCommand;
use App\Contracts\Commands\Type\ITypeListCommand;
use App\Contracts\Services\ITemplateUpdateService;
use App\Events\Template\TemplateUpdateEvent;
use App\Helpers\Builders\AuthorizerFactory;
use App\Http\Requests\TemplateCreateRequest;
use App\Http\Requests\TemplateUpdateRequest;
use App\Template;
use App\Type;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TemplatesController extends Controller
{
    /********************************************************/
    /**
     * @param IAtomCommandInvoker $invoker
     * @param ITemplatePaginatorCommand $templatePaginatorCommand
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(IAtomCommandInvoker $invoker, ITemplatePaginatorCommand $templatePaginatorCommand)
    {
        $invoker->invoke($templatePaginatorCommand);
        $templates = $templatePaginatorCommand->getResult();

        return view('pages.templates.list', compact('templates'));
    }

    /**
     * @param $id
     * @param IAtomCommandInvoker $invoker
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id, IAtomCommandInvoker $invoker)
    {
        $templateGetCommand = app()->makeWith(ITemplateGetCommand::class, [
            'id' => $id
        ]);
        $invoker->invoke($templateGetCommand);
        $template = $templateGetCommand->getResult();

        if($template->documents->count()){
            return back()->with('error', 'Unable to remove template "' . $template->name . '" as long as it has at least one document which use it as base template!');
        }

        $templateDeleteCommand = app()->makeWith(ITemplateDeleteCommand::class, [
            'id' => $template->id
        ]);
        $invoker->invoke($templateDeleteCommand);

        return back()->with('success', 'Template "' . $template->name . '" has been removed with success!');
    }

    /**
     * @param IAtomCommandInvoker $invoker
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(IAtomCommandInvoker $invoker)
    {
        $authorizer = AuthorizerFactory::make('template');
        $authorizer->authorize('template_create');

        $typeListCommand = app()->makeWith(ITypeListCommand::class, []);
        $invoker->invoke($typeListCommand);
        $types = $typeListCommand->getResult();

        return view('pages.templates.add_edit', compact('types'));
    }

    /**
     * @param $id
     * @param IAtomCommandInvoker $invoker
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, IAtomCommandInvoker $invoker)
    {
        $authorizer = AuthorizerFactory::make('template');
        $authorizer->authorize('template_update');

        $templateGetCommand = app()->makeWith(ITemplateGetCommand::class, [
            'id' => $id
        ]);
        $invoker->invoke($templateGetCommand);
        $template = $templateGetCommand->getResult();

        $attributes = $template->attributes;

        return view('pages.templates.add_edit', compact('template', 'attributes'));
    }

    /**
     * @param TemplateCreateRequest $request
     * @param IAtomCommandInvoker $invoker
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TemplateCreateRequest $request, IAtomCommandInvoker $invoker)
    {
        $data = $this->filterOnNull($request->all());

        $templateCreateCommand = app()->makeWith(ITemplateCreateCommand::class, [
            'templateData' => $data
        ]);
        $invoker->invoke($templateCreateCommand);
        $template = $templateCreateCommand->getResult();

        return redirect()->route('templates.edit', ['id' => $template->id]);
    }


//    public function update($id, TemplateUpdateRequest $request, ITransactionCommandInvoker $invoker, Container $container)
//    {
//        $data = $this->filterOnNull($request->all());
//
//        $templateUpdateService = app()->makeWith(ITemplateUpdateService::class, [
//            'container' => $container,
//            'id' => $id,
//            'templateInputData' => $data
//        ]);
//        $invoker->invoke($templateUpdateService);
//        $template = $templateUpdateService->getResult();
//
//
//
//
//        $template = DB::transaction(function () use ($id, $request) {
//            $template = Template::find($id);
//            $template->fill($request->all());
//            $template->save();
//
//            $orders = json_decode($request->input('orders'), true);
//
//            if(is_null($orders) || !is_array($orders)){
//                //TODO
//                throw new \RuntimeException();
//            }
//
//            foreach ($orders as $order) {
//                //TODO
//                if(!isset($order['id']) || !isset($order['order'])){
//                    throw new \RuntimeException();
//                }
//
//                $attribute = Attribute::findOrFail($order['id']);
//                $attribute->order = $order['order'];
//                $attribute->update();
//            }
//
//            return $template;
//        });
//
//        return redirect()->route('templates.edit', ['id' => $template->id]);
//    }

    /********************************************************/

    public function update($id, TemplateUpdateRequest $request)
    {
        $template = DB::transaction(function () use ($id, $request) {
            $template = Template::find($id);
            $template->fill($request->all());
            $template->save();

            $orders = json_decode($request->input('orders'), true);

            if(is_null($orders) || !is_array($orders)){
                //TODO
                throw new \RuntimeException();
            }

            foreach ($orders as $order) {
                //TODO
                if(!isset($order['id']) || !isset($order['order'])){
                    throw new \RuntimeException();
                }

                $attribute = Attribute::findOrFail($order['id']);
                $attribute->order = $order['order'];
                $attribute->update();
            }

            event(new TemplateUpdateEvent(Auth::user(), $template));

            return $template;
        });

        return redirect()->route('templates.edit', ['id' => $template->id]);
    }


}
