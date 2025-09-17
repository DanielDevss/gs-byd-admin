<?php

namespace App\Filament\Resources\Emails\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FormsRelationManager extends RelationManager
{
    protected static string $relationship = 'forms';
    protected static ?string $title = 'Configuración de formularios';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->required(),
                TextInput::make('label')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('label')
            ->columns([
                TextColumn::make('label')
                    ->label('Formulario'),
                SelectColumn::make('type')
                    ->label('Tipo de envío')
                    ->options([
                        'to' => 'Destinatario',
                        'cc' => 'Copia',
                        'bcc' => 'Copia Oculta'
                    ]),
                TextColumn::make('created_at')
                    ->label('Agregado el')
                    ->dateTime('d/m/Y, h:ia')
                    ->alignEnd()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime('d/m/Y, h:ia')
                    ->alignEnd()
                    ->sortable(),
            ])
            ->filters([
            ])
            ->headerActions([])
            ->toolbarActions([]);
    }
}
