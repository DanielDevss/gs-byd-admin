<?php

namespace App\Enum;

use ToneGabes\Filament\Icons\Enums\Phosphor;

enum SlideStatus: string
{
    case PUBLISHED = 'Publicado';
    case INACTIVE = 'Inactivo';
    case SCHEDULED = 'Programado';

    public function label () {
        return match($this) {
            self::PUBLISHED => "Publicado",
            self::INACTIVE => "Inactivo",
            self::SCHEDULED => "Programado"
        };
    }

    public function icon () {
        return match($this) {
            self::PUBLISHED => Phosphor::PlayCircle,
            self::INACTIVE => Phosphor::StopCircle,
            self::SCHEDULED => Phosphor::Clock
        };
    }

    public function color () {
        return match($this) {
            self::PUBLISHED => 'success',
            self::INACTIVE => 'gray',
            self::SCHEDULED => 'primary'
        };
    }
}
