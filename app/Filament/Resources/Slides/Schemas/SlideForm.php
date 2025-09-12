<?php

namespace App\Filament\Resources\Slides\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class SlideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('src')
                    ->label('Imagen')
                    ->directory('slides')
                    ->imageEditor()
                    ->imageCropAspectRatio('160:44')
                    ->imageResizeUpscale()
                    ->columnSpanFull()
                    ->required()
                    ->visibility('public')
                    ->downloadable()
                    ->openable(),
                TextInput::make('name')
                    ->label('Nombre')
                    ->placeholder('Agrega un nombre al slide')
                    ->required(),
                TextInput::make('alt')
                    ->label('Titulo alternativo')
                    ->helperText('Recomendado para SEO y Accesibilidad')
                    ->placeholder('Escribe un titulo alternativo para el slide')
                    ->default(null),
                TextInput::make('url')
                    ->label('Enlace para redirección')
                    ->prefixIcon(Phosphor::Link)
                    ->helperText('Agrega si necesitas que el slide te redirija al dar click sobre el')
                    ->url(),
                Select::make('section')
                    ->hidden()
                    ->options(['Main' => 'Main', 'Modelo' => 'Modelo'])
                    ->default('Main')
                    ->required(),
                Select::make('status')
                    ->options(['Publicado' => 'Publicar', 'Inactivo' => 'Borrador'])
                    ->default('Publicado')
                    ->required(),
                CheckboxList::make('webs')
                    ->label('Mostrar en las siguientes webs')
                    ->bulkToggleable()
                    ->helperText('Marca en las casillas donde quieres que se vea este slide')
                    ->relationship('webs', 'web'),
                Toggle::make('programmable')
                    ->label('Activa para programar el slide')
                    ->onIcon(Phosphor::Alarm)
                    ->offIcon(Phosphor::Prohibit)
                    ->default(0)
                    ->required()
                    ->live(),
                Fieldset::make('Programación')->components([
                    DateTimePicker::make('published_at')
                        ->label('Publicar el')
                        ->minDate(now())
                        ->default(null),
                    DateTimePicker::make('finished_at')
                        ->label('Finalizar el')
                        ->default(null),
                ])
                ->hidden(fn (Get $get) => !$get('programmable'))
            ]);
    }
}
