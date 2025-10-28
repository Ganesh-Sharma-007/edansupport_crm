<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeDocumentController extends Controller
{
    public function store(Request $request, Employee $employee)
    {
        $request->validate([
            'type' => 'required|string',
            'file' => 'required|file|max:20480', // max 20MB
        ]);

        $file = $request->file('file');
        $folder = "employees/{$employee->id}/documents/{$request->type}";

        $path = $file->store($folder, 'public');

        $document = $employee->documents()->create([
            'type'       => $request->type,
            'file_name'  => $file->getClientOriginalName(),
            'file_path'  => $path,
            'mime_type'  => $file->getClientMimeType(),
            'file_size'  => $file->getSize(),
        ]);

        return response()->json([
            'message' => 'Document uploaded successfully!',
            'document' => $document,
        ]);
    }

    public function index(Employee $employee)
    {
        $documents = $employee->documents()
            ->select('id', 'type', 'file_name', 'file_path', 'created_at')
            ->get()
            ->groupBy('type');

        return response()->json($documents);
    }

public function destroy( EmployeeDocument $document)
{
    // dd($document);
    // delete file from storage
    if ($document->file_path) {
        Storage::disk('public')->delete($document->file_path);
    }

    // delete document record
    $document->delete();

    return response()->json(['message' => 'Document deleted successfully']);
}


}
