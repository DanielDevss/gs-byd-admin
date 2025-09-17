<?php

namespace App\Filament\Resources\Slides\Tables;

use App\Enum\SlideStatus;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class SlidesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('position')
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                ImageColumn::make('src')
                    ->label('Slide')
                    ->openUrlInNewTab()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        SlideStatus::PUBLISHED->value => SlideStatus::PUBLISHED->color(),
                        SlideStatus::INACTIVE->value => SlideStatus::INACTIVE->color(),
                        SlideStatus::SCHEDULED->value => SlideStatus::SCHEDULED->color(),
                    })
                    ->icon(fn ($state) => match($state) {
                        SlideStatus::PUBLISHED->value => SlideStatus::PUBLISHED->icon(),
                        SlideStatus::INACTIVE->value => SlideStatus::INACTIVE->icon(),
                        SlideStatus::SCHEDULED->value => SlideStatus::SCHEDULED->icon(),
                    }),
                TextColumn::make('published_at')
                    ->label('Publicado el')
                    ->dateTime('d/m/Y, h:i a')
                    ->alignEnd()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('finished_at')
                    ->label('Finaliza el')
                    ->dateTime('d/m/Y, h:i a')
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime('d/m/Y, h:i a')
                    ->alignEnd()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime('d/m/Y, h:i a')
                    ->alignEnd()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
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
