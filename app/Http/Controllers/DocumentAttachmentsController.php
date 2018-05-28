<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Entities\File as FileModel;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class DocumentAttachmentsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'files.*' => 'required|file',
        ]);

        $files = $request->file('files');

        $createdFiles = [];
        foreach ($files as $file) {
            $originalName = $file->getClientOriginalName();
            $path = $file->storeAs('files', $originalName, 'public');

            $savedFile = FileModel::create([
                'path' => $path,
                'original_name' => $originalName
            ]);

            $createdFiles[]= [
                'id' => $savedFile->id,
                'type' => File::mimeType(public_path('storage/'.$path)),
                'url' => asset('storage/' . $path),
                'name' => $originalName,
                'size' => File::size(public_path('storage/'.$path)),
                'deleteUrl' => route('document_attachments.delete', [$savedFile->id]),
                'deleteType' => 'DELETE'
            ];
        }

        return response()->json(['files' => $createdFiles]);
    }

    public function delete($id, Request $request){
        $file = FileModel::findOrFail($id);
        File::delete(public_path('storage/'.$file->path));
        $file->delete();

        return response()->json([$file->id => true]);
    }
}