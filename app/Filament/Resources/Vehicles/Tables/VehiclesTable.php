<?php

namespace App\Filament\Resources\Vehicles\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class VehiclesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('category.name')->label('Categoría')
            ])
            ->columns([
                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Modelo')
                    ->searchable(),
                ImageColumn::make('cover')
                    ->label('Miniatura')
                    ->circular()
                    ->alignCenter(),
                TextColumn::make('year')
                    ->label('Año')
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Precio')
                    ->money('MXN')
                    ->prefix('$')
                    ->numeric()
                    ->alignEnd()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime()
                    ->sortable()
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime('d-m-Y')
                    ->sortable()
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Filtrar por categoría')
                    ->relationship('category', 'name'),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
