<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate the uploaded file
            $validated = $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // max 10MB
            ]);

            // Store the file in public/images/upload
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/upload'), $filename);

                return response()->json([
                    'success' => true,
                    'filename' => $filename,
                    'url' => asset('images/upload/' . $filename)
                ], 200);
            }

            return response()->json('No file uploaded', 400);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation error as string for Dropzone
            $errors = $e->errors();
            $errorMessage = '';

            foreach ($errors as $field => $messages) {
                $errorMessage .= implode(', ', $messages);
            }

            return response()->json($errorMessage ?: 'Validation failed', 422);
        } catch (\Exception $e) {
            return response()->json('Upload failed: ' . $e->getMessage(), 500);
        }
    }
}
