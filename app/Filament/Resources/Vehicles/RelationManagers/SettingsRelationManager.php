<?php

namespace App\Filament\Resources\Vehicles\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingsRelationManager extends RelationManager
{
    protected static string $relationship = 'settings';

    protected static ?string $title = "Personalizados";
    protected static ?string $modelLabel = "personalizado";

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->default(null),

                Select::make('section')
                    ->label('Sección')
                    ->options([
                        'Exterior' => 'Exterior',
                        'Interior' => 'Interior',
                        'Rines' => 'Rines',
                    ])
                    ->required()
                    ->reactive(),
                ColorPicker::make('icon_color')
                    ->label('Color')
                    ->visible(fn(Get $get) => $get('section') !== 'Rines')
                    ->required(fn(Get $get) => $get('section') !== 'Rines')
                    // Opcional: cuando editas un registro existente, precarga desde icon
                    ->afterStateHydrated(function (Get $get, Set $set) {
                        if ($get('section') !== 'Rines') {
                            $set('icon_color', $get('icon'));
                        }
                    })
                    ->dehydrated(false),
                FileUpload::make('icon_file')
                    ->label('Icono (Rin)')
                    ->directory('model_custom')
                    ->visibility('public')
                    ->image() // o quítalo si subirás SVG
                    ->visible(fn(Get $get) => $get('section') === 'Rines')
                    ->required(fn(Get $get) => $get('section') === 'Rines')
                    ->afterStateHydrated(function (Get $get, Set $set) {
                        if ($get('section') === 'Rines') {
                            $set('icon_file', $get('icon'));
                        }
                    })
                    ->dehydrated(false),
                Hidden::make('icon')
                    ->dehydrateStateUsing(
                        fn(Get $get) =>
                        $get('section') === 'Rines'
                        ? $get('icon_file')
                        : $get('icon_color')
                    ),
                FileUpload::make('preview')
                    ->directory('model_custom')
                    ->image()
                    ->visibility('public')
                    ->imageEditor()
                    ->imageCropAspectRatio('6:4')
                    ->required()
                    ->openable()
                    ->downloadable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('section')
                    ->label('Sección')
                    ->color(fn (string $state): string => match($state) {
                        'Exterior' => 'primary',
                        'Interior' => 'warning',
                        'Rines' => 'gray'
                    })
                    ->badge(),
                ImageColumn::make('preview')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->alignEnd()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                // DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
