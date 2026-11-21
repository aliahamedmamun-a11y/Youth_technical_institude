<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Safely store an uploaded file on disk even if the PHP fileinfo extension is missing.
     */
    public static function store(UploadedFile $file, string $folder = 'uploads', string $disk = 'public'): string
    {
        $folderName = trim($folder, '/\\');
        $originalExt = strtolower($file->getClientOriginalExtension());

        if (empty($originalExt)) {
            $clientMime = $file->getClientMimeType();
            $mimeMap = [
                'image/jpeg' => 'jpg',
                'image/jpg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp',
                'image/svg+xml' => 'svg',
                'application/pdf' => 'pdf',
            ];
            $originalExt = $mimeMap[$clientMime] ?? 'jpg';
        }

        $filename = Str::random(40) . '.' . $originalExt;
        $relativePath = $folderName . '/' . $filename;
        $tempPath = $file->getRealPath() ?: $file->getPathname();

        // Target 1: storage_path('app/public/' . $folderName)
        $storageTargetDir = storage_path('app/public' . DIRECTORY_SEPARATOR . $folderName);
        if (! is_dir($storageTargetDir)) {
            @mkdir($storageTargetDir, 0777, true);
        }
        $storageFullPath = $storageTargetDir . DIRECTORY_SEPARATOR . $filename;

        // Target 2: public_path('storage/' . $folderName)
        $publicTargetDir = public_path('storage' . DIRECTORY_SEPARATOR . $folderName);
        if (! is_dir($publicTargetDir)) {
            @mkdir($publicTargetDir, 0777, true);
        }
        $publicFullPath = $publicTargetDir . DIRECTORY_SEPARATOR . $filename;

        if ($tempPath && file_exists($tempPath)) {
            @copy($tempPath, $storageFullPath);
            @copy($tempPath, $publicFullPath);

            if (! file_exists($storageFullPath) && ! file_exists($publicFullPath)) {
                $content = @file_get_contents($tempPath);
                if ($content !== false) {
                    @file_put_contents($storageFullPath, $content);
                    @file_put_contents($publicFullPath, $content);
                }
            }
        }

        return $relativePath;
    }

    /**
     * Safely delete a file from disk even if the PHP fileinfo extension is missing.
     */
    public static function delete(?string $path, string $disk = 'public'): bool
    {
        if (empty($path) || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return false;
        }

        $cleanPath = ltrim(str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $path), DIRECTORY_SEPARATOR);

        $storagePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $cleanPath);
        if (file_exists($storagePath) && is_file($storagePath)) {
            @unlink($storagePath);
        }

        $publicPath = public_path('storage' . DIRECTORY_SEPARATOR . $cleanPath);
        if (file_exists($publicPath) && is_file($publicPath)) {
            @unlink($publicPath);
        }

        return true;
    }
}
