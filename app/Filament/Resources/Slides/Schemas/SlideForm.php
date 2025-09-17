<?php

namespace App\Filament\Resources\Slides\Schemas;

use App\Enum\SlideStatus;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
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
                    ->imageCropAspectRatio('144:60')
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
                ToggleButtons::make('status')
                    ->label("Estado del slide")
                    ->colors([
                        SlideStatus::PUBLISHED->value => SlideStatus::PUBLISHED->color(),
                        SlideStatus::SCHEDULED->value => SlideStatus::SCHEDULED->color(),
                        SlideStatus::INACTIVE->value => SlideStatus::INACTIVE->color(),
                    ])
                    ->icons([
                        SlideStatus::PUBLISHED->value => SlideStatus::PUBLISHED->icon(),
                        SlideStatus::SCHEDULED->value => SlideStatus::SCHEDULED->icon(),
                        SlideStatus::INACTIVE->value => SlideStatus::INACTIVE->icon(),
                    ])
                    ->options([
                        SlideStatus::PUBLISHED->value => SlideStatus::PUBLISHED->label(),
                        SlideStatus::SCHEDULED->value => SlideStatus::SCHEDULED->label(),
                        SlideStatus::INACTIVE->value => SlideStatus::INACTIVE->label(),
                    ])
                    ->inline()
                    ->live(),
                CheckboxList::make('webs')
                    ->label('Mostrar en las siguientes webs')
                    ->bulkToggleable()
                    ->helperText('Marca en las casillas donde quieres que se vea este slide')
                    ->relationship('webs', 'web'),
                Fieldset::make('Programación')->components([
                    DateTimePicker::make('published_at')
                        ->label('Publicar el')
                        ->minDate(now())
                        ->default(null),
                    DateTimePicker::make('finished_at')
                        ->label('Finalizar el')
                        ->default(null),
                ])
                    ->hidden(fn(Get $get) => $get('status') !== SlideStatus::SCHEDULED->value)
            ]);
    }
}
