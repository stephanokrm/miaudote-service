<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Intervention;

/**
 *
 */
class ImageService
{
    /**
     * @param  UploadedFile  $file
     * @return string
     */
    public function upload(UploadedFile $file): string
    {
        $path = "uploads/{$file->hashName()}";

        Storage::put(
            $path,
            Intervention::make($file->path())->fit(500)->encode()->getEncoded(),
            ['visibility' => 'public']
        );

        return $path;
    }

    /**
     * @param  string  $path
     * @return bool
     */
    public function delete(string $path): bool
    {
        return Storage::delete($path);
    }
}
