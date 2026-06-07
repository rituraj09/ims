<?php
// app/Http/Controllers/Admin/AssetDocumentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssetDocument;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AssetDocumentController extends Controller
{
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'asset_id'      => ['required', 'exists:assets,id'],
            'document_type' => ['required', 'string'],
            'title'         => ['required', 'string', 'max:200'],
            'file'          => ['required', 'file', 'max:10240',
                               'mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx'],
            'description'   => ['nullable', 'string'],
        ]);

        $file = $request->file('file');
        $path = $file->store("asset-documents/{$request->asset_id}", 'public');

        $doc = AssetDocument::create([
            'asset_id'      => $request->asset_id,
            'document_type' => $request->document_type,
            'title'         => $request->title,
            'description'   => $request->description,
            'file_path'     => $path,
            'file_name'     => $file->getClientOriginalName(),
            'file_type'     => $file->getMimeType(),
            'file_size'     => $file->getSize(),
            'assignment_id' => $request->assignment_id,
            'maintenance_id'=> $request->maintenance_id,
            'uploaded_by'   => auth()->id(),
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Document uploaded successfully.',
            'document' => $doc->load('uploadedBy'),
        ]);
    }

    public function destroy(AssetDocument $doc): JsonResponse
    {
        Storage::disk('public')->delete($doc->file_path);
        $doc->delete();

        return response()->json(['success' => true, 'message' => 'Document deleted.']);
    }

    public function download(AssetDocument $doc)
    {
        if (!Storage::disk('public')->exists($doc->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($doc->file_path, $doc->file_name);
    }
}
