<?php

namespace JeffersonGoncalves\Filament\User\Resources\Users\Tables;

use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use JeffersonGoncalves\Filament\User\Resources\Users\Actions\ImpersonateUserAction;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns(static::columns())
            ->filters([
                //
            ])
            ->actions([
                ImpersonateUserAction::table(),
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    /**
     * Override (or merge with parent::columns()) to add columns.
     *
     * @return array<int, Column>
     */
    public static function columns(): array
    {
        return [
            IconColumn::make('status')
                ->boolean()
                ->trueIcon('heroicon-o-check-badge')
                ->falseIcon('heroicon-o-x-mark')
                ->sortable(),
            TextColumn::make('name')
                ->searchable()
                ->sortable(),
            TextColumn::make('email')
                ->searchable()
                ->sortable()
                ->toggleable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
