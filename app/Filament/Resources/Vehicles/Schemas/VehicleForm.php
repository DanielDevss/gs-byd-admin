<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Wizard\Step::make('Modelo')
                        ->icon(Phosphor::Car)
                        ->columns(2)
                        ->components([
                            Select::make('category_id')
                                ->label('Categoría')
                                ->relationship('category', 'name')
                                ->required(),
                            TextInput::make('name')
                                ->label('Nombre del modelo')
                                ->placeholder('Escribe el nombre del modelo')
                                ->required(),
                            TextInput::make('year')
                                ->label('Año')
                                ->placeholder('Ingresa el año del modelo')
                                ->required(),
                            TextInput::make('slug_byd')
                                ->placeholder('Ingresa el slug de BYD')
                                ->helperText('Este slug lo puedes tomar de la URL de la página oficial de BYD')
                                ->default(null),
                            FileUpload::make('technical_sheet')
                                ->label('Ficha técnica')
                                ->downloadable()
                                ->maxSize(250000)
                                ->openable()
                                ->acceptedFileTypes(['application/pdf'])
                                ->helperText('Sube el PDF de la ficha técnica del modelo')
                        ]),
                    Wizard\Step::make('Imagenes')
                        ->icon(Phosphor::ImagesSquare)
                        ->columns(3)
                        ->components([
                            FileUpload::make('cover')
                                ->label('Miniatura')
                                ->image()
                                ->mimeTypeMap(['image/png'])
                                ->imageEditor()
                                ->openable()
                                ->downloadable()
                                ->visibility('public')
                                ->required()
                                ->directory('covers'),
                            FileUpload::make('banner')
                                ->label('Banner principal')
                                ->image()
                                ->mimeTypeMap(['image/webp', 'image/jpeg', 'image/jpg', 'image/png'])
                                ->imageEditor()
                                ->imageEditorAspectRatios(['144:60', '16:9', '2:1', '32:9',])
                                ->directory('slides')
                                ->visibility('public')
                                ->openable()
                                ->downloadable()
                                ->required(),
                            FileUpload::make('banner_attributes')
                                ->label('Banner de atributos')
                                ->image()
                                ->mimeTypeMap(['image/webp', 'image/jpeg', 'image/jpg', 'image/png'])
                                ->imageEditor()
                                ->imageEditorAspectRatios(['144:60','16:9', '2:1', '32:9',])
                                ->directory('slides')
                                ->visibility('public')
                                ->openable()
                                ->downloadable()
                                ->required(),
                            Repeater::make('pictures')
                                ->label('Imagenes para galeria')
                                ->columnSpanFull()
                                ->grid(3)
                                ->relationship('pictures')
                                ->reorderable()
                                ->addActionLabel('Agregar imagen')
                                ->components([
                                    FileUpload::make('src')->hiddenLabel()->directory('galery')->mimeTypeMap(['image/png', 'image/webp', 'image/jpg', 'image/jpeg'])->required()->openable()
                                        ->downloadable()->visibility('public'),
                                    TextInput::make('alt')->label('Titulo alternativo')->placeholder('Escribe un titulo alternativo')
                                ])
                        ]),
                    Wizard\Step::make('Atributos')
                        ->icon(Phosphor::SquaresFour)
                        ->components([
                            Repeater::make('attributes')
                                ->label('Atributos del vehículo')
                                ->hiddenLabel()
                                ->columnSpanFull()
                                ->columns(2)
                                ->relationship('attributes')
                                ->reorderable()
                                ->addActionLabel('Agregar atributo')
                                ->components([
                                    TextInput::make('title')->label('Titulo')->placeholder('Ej.: Cell To Body (CTB)')->required(),
                                    TextInput::make('description')->label('Subtitulo/Descripción')->placeholder('Ej.: Tecnología innovadora, segura y estable')
                                ])
                        ]),
                    Wizard\Step::make('Versiones')
                        ->icon(Phosphor::CarProfile)
                        ->components([
                            Repeater::make('versions')
                                ->hiddenLabel()
                                ->columnSpanFull()
                                ->relationship('versions')
                                ->columns(2)
                                ->addActionLabel('Añadir versión')
                                ->minItems(1)
                                ->required()
                                ->components([
                                    TextInput::make('name')
                                        ->label('Nombre de la versión')
                                        ->placeholder('Ingresa el nombre de la versión')
                                        ->required(),
                                    TextInput::make('price')
                                        ->label('Precio de la versión')
                                        ->placeholder('Ingresa el precio de la versión')
                                        ->required()
                                ])
                        ])
                ])
                    ->skippable()
                    ->columnSpanFull(),
            ]);
    }
}
