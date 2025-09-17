<?php

namespace App\Filament\Resources\Emails\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EmailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->label('Correo electrónico')
                    ->placeholder('Ingresa el correo electrónico')
                    ->unique('emails', 'email')
                    ->email()
                    ->required(),
                TextInput::make('name')
                    ->label('Nombre/Puesto del propietario')
                    ->placeholder('Escribe un identificador para este correo')
                    ->unique('emails', 'name')
                    ->required(),
                CheckboxList::make('webs')
                    ->label('Webs afiliadas')
                    ->helperText('Marca las webs de donde deseas que esta dirección reciba correos')
                    ->relationship('webs', 'web')
                    ->bulkToggleable(),
                CheckboxList::make('forms')
                    ->label('Formularios afiliados')
                    ->helperText('Marca los formularios de los que deseas que reciba correos esta dirección')
                    ->relationship('forms', 'label')
                    ->bulkToggleable()
            ]);
    }
}
