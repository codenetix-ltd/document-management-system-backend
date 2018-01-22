<?php

namespace App\Http\Controllers;

use App\Contracts\Commands\Label\ILabelCreateCommand;
use App\Contracts\Commands\Label\ILabelDeleteCommand;
use App\Contracts\Commands\Label\ILabelGetCommand;
use App\Contracts\Commands\Label\ILabelUpdateCommand;
use App\Contracts\Commands\Paginators\ILabelPaginatorCommand;
use App\Helpers\Builders\AuthorizerFactory;
use App\Http\Requests\LabelCreateRequest;

/**
 * Class LabelsController
 * @package App\Http\Controllers
 */
class LabelsController extends Controller
{
    /**
     * @param ILabelPaginatorCommand $command
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ILabelPaginatorCommand $command)
    {
        $command->execute();
        $labels = $command->getResult();

        return view('pages.labels.list', compact('labels'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $authorizer = AuthorizerFactory::make('label');
        $authorizer->authorize('label_create');
        return view('pages.labels.add_edit');
    }

    /**
     * @param LabelCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LabelCreateRequest $request)
    {
        $data = $this->filterOnNull($request->all());

        $labelCreateCommand = app()->makeWith(ILabelCreateCommand::class, [
            'inputData' => $data
        ]);
        $labelCreateCommand->execute();
        $label = $labelCreateCommand->getResult();

        return redirect()->route('labels.list')->with('success', 'Label ' . $label->name . ' has been created with success!');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $authorizer = AuthorizerFactory::make('label');
        $authorizer->authorize('label_update');

        $labelGetCommand = app()->makeWith(ILabelGetCommand::class, [
            'id' => $id
        ]);
        $labelGetCommand->execute();
        $label = $labelGetCommand->getResult();

        return view('pages.labels.add_edit', compact('label'));
    }

    /**
     * @param $id
     * @param LabelCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, LabelCreateRequest $request)
    {
        $data = $this->filterOnNull($request->all());

        $labelUpdateCommand = app()->makeWith(ILabelUpdateCommand::class, [
            'id' => $id,
            'inputData' => $data,
        ]);
        $labelUpdateCommand->execute();
        $label = $labelUpdateCommand->getResult();

        return redirect()->route('labels.edit', ['id' => $label->id])->with('success', 'Label ' . $label->name . ' has been updated with success!');;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $labelGetCommand = app()->makeWith(ILabelGetCommand::class, [
            'id' => $id
        ]);
        $labelGetCommand->execute();
        $label = $labelGetCommand->getResult();

        if ($label->documents->count()) {
            return back()->with('error', 'Unable to remove label "' . $label->name . '" as long as it has at least one document which use this label!');
        }

        $labelDeleteCommand = app()->makeWith(ILabelDeleteCommand::class, [
            'id' => $label->id
        ]);
        $labelDeleteCommand->execute();

        return back()->with('success', 'Label "' . $label->name . '" has been removed with success!');
    }
}
