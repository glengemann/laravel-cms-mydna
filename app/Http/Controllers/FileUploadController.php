<?php

namespace App\Http\Controllers;

use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileUploadController extends Controller
{
    public function __construct(readonly private FilesystemManager $storage)
    {
    }

    public function upload(Request $request): JsonResponse
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $this->storage->put('uploads', $file);

            return response()
                ->json(['file' => $path], Response::HTTP_OK);
        }

        return response()
            ->json(['message' => 'No file uploaded'], Response::HTTP_BAD_REQUEST);
    }

    public function serve($path): StreamedResponse
    {
        return $this->storage->response("uploads/$path");
    }
}
