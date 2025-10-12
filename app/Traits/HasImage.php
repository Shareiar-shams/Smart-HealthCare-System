<?php

namespace App\Traits;

use App\Services\ImageService as ServicesImageService;

trait HasImage
{
    public function getImageUrl($type = 'original')
    {
        if (!$this->image) {
            return asset("default/{$type}.png"); // fallback image
        }

        $folder = strtolower(class_basename($this)); 
        return app(ServicesImageService::class)->getImageUrl($folder.'s', $this->image, $type);
    }

    // Dynamic accessors
    public function getAvatarAttribute()
    {
        return $this->getImageUrl('avatar');
    }

    public function getThumbnailAttribute()
    {
        return $this->getImageUrl('thumbnail');
    }

    public function getMediumAttribute()
    {
        return $this->getImageUrl('medium');
    }

    public function getFullAttribute()
    {
        return $this->getImageUrl('full');
    }
}