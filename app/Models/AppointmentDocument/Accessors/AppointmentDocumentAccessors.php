<?php

namespace App\Models\AppointmentDocument\Accessors;

use App\Services\ImageService;

trait AppointmentDocumentAccessors
{
    public function getImageUrlAttribute(): ?string
    {
        $imageService = app(ImageService::class);
        return $this->file_path ? $imageService->getSingleImageUrl('appointment_documents', $this->file_path) : asset('images/default-category.png');
    }
}