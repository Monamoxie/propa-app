<?php

namespace App\Labs;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;

class ImageProcessor
{

    /**
     * @var
     */
    public $fileWidth;

    /**
     * @var
     */
    public $fileHeight;

    /**
     * @var
     */
    public $extension;

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
    
    
    /**
     * @param UploadedFile $file
     * @param string $uploadType
     * @param mixed $subDir=null
     * @param mixed $newWidth=null
     * @param mixed $newHeight=null
     * @param mixed $newSize=null
     * 
     * @return array
     */
    public function saveFromDisk(UploadedFile $file, string $uploadType, $subDir=null, $newWidth=null, $newHeight=null, $newSize=null): array 
    {     
        
        $fileProps = getimagesize($file);
        $this->fileWidth = $fileProps[0];
        $this->fileHeight = $fileProps[1]; 
        $this->extension = strtolower($file->extension());
        
        $subDirPath = $subDir != null ? $subDir. '/' : '';

        $newFileName = $this->createNewFileName();
        try {
            if ($newWidth !== null || $newHeight !== null) { 
                
                // No resizing is happening yet because 
                $resizeStandardSize = Image::make($file->getRealPath())
                ->resize($newWidth, $newHeight, function($constraint) {
                    $constraint->aspectRatio();
                })->stream(); 
                Storage::disk('public')->put($subDirPath . $newFileName, $resizeStandardSize); 
            } 
            else { 
                $stream = Image::make($file->getRealPath())->stream(); 
                Storage::disk('public')->put($subDirPath . $newFileName, $stream); 
            } 
            return [true, $newFileName];
        } catch (\Throwable $th) {
            return [false, $th->getMessage()];
        }
    }


    /**
     * @param string $uploadType
     * 
     * @return string
     */
    private function createNewFileName(): string
    {  
        return time() .'.'. $this->extension;
    }
 
}