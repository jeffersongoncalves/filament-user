<?php

namespace JeffersonGoncalves\Filament\User\Resources\UserResource\Tables;

use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use JeffersonGoncalves\Filament\User\Resources\UserResource\Actions\ImpersonateUserAction;
use JeffersonGoncalves\Filament\User\UserPlugin;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        $plugin = UserPlugin::current();
        $actions = static::recordActions();

        return $table
            ->columns(static::columns())
            ->filters([
                //
            ])
            ->actions(
                $plugin->shouldGroupRecordActions() ? [ActionGroup::make($actions)] : $actions,
                position: $plugin->getRecordActionsPosition(),
            );
    }

    /**
     * Override (or merge with parent::recordActions()) to add record actions.
     *
     * @return array<int, Action>
     */
    public static function recordActions(): array
    {
        return [
            ImpersonateUserAction::table(),
            ViewAction::make(),
            EditAction::make(),
            DeleteAction::make(),
        ];
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
                ->label(__('filament-user::resources/user.fields.status'))
                ->boolean()
                ->trueIcon('heroicon-o-check-badge')
                ->falseIcon('heroicon-o-x-mark')
                ->sortable(),
            TextColumn::make('name')
                ->label(__('filament-user::resources/user.fields.name'))
                ->searchable()
                ->sortable(),
            TextColumn::make('email')
                ->label(__('filament-user::resources/user.fields.email'))
                ->searchable()
                ->sortable()
                ->toggleable(),
            TextColumn::make('created_at')
                ->label(__('filament-user::resources/user.fields.created_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->label(__('filament-user::resources/user.fields.updated_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
