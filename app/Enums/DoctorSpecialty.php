<?php

namespace App\Enums;

enum DoctorSpecialty: string
{
    case GENERAL_MEDICINE = 'General Medicine';
    case CARDIOLOGY = 'Cardiology';
    case DERMATOLOGY = 'Dermatology';
    case NEUROLOGY = 'Neurology';
    case ORTHOPEDICS = 'Orthopedics';
    case PEDIATRICS = 'Pediatrics';
    case PSYCHIATRY = 'Psychiatry';
    case OPHTHALMOLOGY = 'Ophthalmology';
    case DENTISTRY = 'Dentistry';
    case GYNECOLOGY = 'Gynecology';
    
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}