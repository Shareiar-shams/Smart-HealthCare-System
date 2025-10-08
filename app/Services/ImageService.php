<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
    protected $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Store a single image without creating variants
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @param string|null $filename
     * @param int|null $width
     * @param int|null $height
     * @return string
     */
    public function storeSingleImage($file, $folder, $filename = null, $width = null, $height = null)
    {
        $filename = $filename ?? uniqid() . '.' . $file->getClientOriginalExtension();
        $path = storage_path('app/public/' . $folder);

        // Create directory if it doesn't exist
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // If width and height are provided, resize the image
        if ($width && $height) {
            $image = $this->imageManager->read($file)->cover($width, $height);
            $image->save($path . '/' . $filename);
        } else {
            // Store original image without resizing
            $file->storeAs($folder, $filename, 'public');
        }

        return $filename;
    }

    public function uploadAndResize($file, $folder, $filename = null)
    {
        $filename = $filename ?? uniqid().'.'.$file->getClientOriginalExtension();

        // Original
        $path = $file->storeAs($folder.'/original', $filename, 'public');

        // Avatar (50x50)
        $this->resizeAndSave($file, $folder.'/avatar', $filename, 50, 50);

        // Thumbnail (150x150)
        $this->resizeAndSave($file, $folder.'/thumbnail', $filename, 150, 150);

        // Medium (300x300)
        $this->resizeAndSave($file, $folder.'/medium', $filename, 300, 300);

        // Full (800x800)
        $this->resizeAndSave($file, $folder.'/full', $filename, 800, 800);

        return $filename;
    }

    private function resizeAndSave($file, $folder, $filename, $width, $height)
    {
        $image = $this->imageManager->read($file)->cover($width, $height);
        $path = storage_path('app/public/'.$folder);
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $image->save($path.'/'.$filename);
    }

    public function getImageUrl($folder, $filename, $type = 'original')
    {
        return asset("storage/{$folder}/{$type}/{$filename}");
    }

    /**
     * Get URL for a single stored image
     *
     * @param string $folder
     * @param string $filename
     * @return string
     */
    public function getSingleImageUrl($folder, $filename)
    {
        return asset("storage/{$folder}/{$filename}");
    }
}
