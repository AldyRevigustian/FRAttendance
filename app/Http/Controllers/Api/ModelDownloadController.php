<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use ZipArchive;

class ModelDownloadController extends Controller
{
    private $modelPath;

    public function __construct()
    {
        $this->modelPath = base_path('scripts/Model');
    }

    public function getModelList()
    {
        try {
            if (!File::exists($this->modelPath)) {
                return response()->json(['error' => 'Model directory not found'], 404);
            }

            $files = File::files($this->modelPath);
            $fileList = [];

            foreach ($files as $file) {
                $fileList[] = [
                    'name' => $file->getFilename(),
                    'size' => $file->getSize(),
                    'modified' => date('Y-m-d H:i:s', $file->getMTime()),
                    'download_url' => url('/api/models/download/' . $file->getFilename())
                ];
            }

            return response()->json([
                'success' => true,
                'files' => $fileList,
                'total' => count($fileList)
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function downloadModel($filename)
    {
        try {
            $filePath = $this->modelPath . DIRECTORY_SEPARATOR . $filename;

            if (!File::exists($filePath)) {
                return response()->json(['error' => 'File not found'], 404);
            }

            $allowedExtensions = ['h5', 'pb', 'onnx', 'pkl', 'json', 'xml', 'bin', 'npy'];
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (!in_array($extension, $allowedExtensions)) {
                return response()->json(['error' => 'File type not allowed'], 403);
            }

            return Response::download($filePath);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function downloadAllModels()
    {
        try {
            if (!File::exists($this->modelPath)) {
                return response()->json(['error' => 'Model directory not found'], 404);
            }

            $zipFileName = 'models_' . date('Y-m-d_H-i-s') . '.zip';
            $zipPath = storage_path('app/temp/' . $zipFileName);

            if (!File::exists(storage_path('app/temp'))) {
                File::makeDirectory(storage_path('app/temp'), 0755, true);
            }

            $zip = new ZipArchive;
            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                $files = File::files($this->modelPath);

                foreach ($files as $file) {
                    $zip->addFile($file->getRealPath(), $file->getFilename());
                }

                $zip->close();

                return Response::download($zipPath)->deleteFileAfterSend(true);
            } else {
                return response()->json(['error' => 'Cannot create zip file'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
