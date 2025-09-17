<?php

namespace App\Enum;

enum ContactType: string
{
    case QUOTE = 'quote';
    case QUOTE_VERSION = 'quote_version';
    case DRIVE = 'drive';
    case SERVICE = 'service';
    case CONTACT = 'contact';

    public function subject(): string
    {
        return match ($this) {
            self::QUOTE => 'Un prospecto quiere cotizar un vehículo',
            self::DRIVE => 'Un prospecto quiere manejar un vehículo',
            self::SERVICE => 'Alguién solicita información de servicios',
            self::CONTACT => 'Un prospecto ha dejado su información',
        };
    }

    public function title(): string
    {
        return match ($this) {
            self::QUOTE => 'Cotización de modelo',
            self::DRIVE => 'Solcitud para prueba de manejo',
            self::SERVICE => 'Información de servicios',
            self::CONTACT => 'Contacto de prospecto',
        };
    }
}
