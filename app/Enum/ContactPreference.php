<?php

namespace App\Enum;

enum ContactPreference: string
{
    case WHATSAPP = 'WhatsApp';
    case CALL = 'Llamada';
    case EMAIL = 'Correo Electrónico';
}
