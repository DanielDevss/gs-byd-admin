<?php

namespace App\Enum;

enum SentType: string
{
    case TO = 'to';
    case CC = 'cc';
    case BCC = 'bcc';

    public function label()
    {
        return match ($this) {
            self::TO => 'Destinatario',
            self::CC => 'Copia',
            self::BCC => 'Copia oculta'
        };
    }
}
