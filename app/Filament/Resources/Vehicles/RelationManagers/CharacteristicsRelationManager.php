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
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class CharacteristicsRelationManager extends RelationManager
{
    protected static string $relationship = 'characteristics';
    protected static ?string $title = 'Caracteristicas';
    protected static ?string $modelLabel = 'caracterisitca';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()->columnSpanFull()->tabs([
                    Tabs\Tab::make('Información')->icon(Phosphor::Info)->components([
                        TextInput::make('title')
                            ->label('Titulo')
                            ->placeholder('Escribe el titulo de la tarjeta')
                            ->columnSpanFull()
                            ->required(),
                        RichEditor::make('text')
                            ->label('Contenido')
                            ->placeholder('Agrega contenido a la tarjeta')
                            ->columnSpanFull()
                            ->toolbarButtons([])
                            ->floatingToolbars([
                                'paragraph' => [
                                    'bold',
                                    'italic',
                                    'underline',
                                    'strike',
                                    'alignStart',
                                    'alignEnd',
                                    'alignCenter'
                                ],
                                'heading' => [
                                    'h1',
                                    'h2',
                                    'h3',
                                ],
                            ]),
                    ]),
                    Tabs\Tab::make('Slides')->icon(Phosphor::Cards)->components([
                        Repeater::make('elements')->relationship('elements')->columns(2)->hiddenLabel()->components([
                            TextInput::make('title')->columnSpanFull()->label('Titulo')->placeholder('Escribe un titulo')->required(),
                            RichEditor::make('text')->label('Contenido')->placeholder('Escribe contenido a este slide')->required()->toolbarButtons([])
                                ->floatingToolbars([
                                    'paragraph' => [
                                        'bold',
                                        'italic',
                                        'underline',
                                        'strike',
                                        'alignStart',
                                        'alignEnd',
                                        'alignCenter'
                                    ],
                                    'heading' => [
                                        'h1',
                                        'h2',
                                        'h3',
                                    ],
                                ]),
                            FileUpload::make('image')->label('Imagen')->directory('caracteristics')->image()->downloadable()->openable(),
                        ])
                    ])
                ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->reorderable('position')
            ->columns([
                TextColumn::make('title')
                    ->label('Titulo')
                    ->searchable(),
                TextColumn::make('elements_count')
                    ->label('Elementos')
                    ->counts('elements'),
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
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
