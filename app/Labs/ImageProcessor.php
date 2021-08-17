<?php

namespace App\Labs;

use Illuminate\Support\Facades\Log;

class ImageProcessor
{
    public function saveFromUrl(string $url, string $imageName, $subDir=null): string
    { 
        $formattedName = $imageName . '.png';
        $subDirPlacer = $subDir === null ? '' : $subDir . '/';
        $path = storage_path('app/public/') . $subDirPlacer;
        $imgFile = $path . $formattedName;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        try {
            if (file_put_contents($imgFile, file_get_contents($url))) {
                return $formattedName;
            }
        } catch (\Throwable $th) {
            Log::error('Image from url could not be loaded. Skipping...', [$url]);
        }
        return '';
    }
}