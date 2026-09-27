<?php

namespace JeffersonGoncalves\Filament\User\Resources\Users;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use JeffersonGoncalves\Filament\User\Models\User;
use JeffersonGoncalves\Filament\User\Resources\Users\Pages\CreateUser;
use JeffersonGoncalves\Filament\User\Resources\Users\Pages\EditUser;
use JeffersonGoncalves\Filament\User\Resources\Users\Pages\ListUsers;
use JeffersonGoncalves\Filament\User\Resources\Users\Pages\ViewUser;
use JeffersonGoncalves\Filament\User\Resources\Users\Schemas\UserForm;
use JeffersonGoncalves\Filament\User\Resources\Users\Schemas\UserInfolist;
use JeffersonGoncalves\Filament\User\Resources\Users\Tables\UsersTable;
use JeffersonGoncalves\Filament\User\UserPlugin;
use JeffersonGoncalves\User\Observers\UserObserver;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::User;

    protected static bool $isGloballySearchable = true;

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * The app's user model (config/auth.php), so App\Models\User is used.
     */
    public static function getModel(): string
    {
        return config('auth.providers.users.model') ?: static::$model;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return static::getUrl('view', ['record' => $record]);
    }

    public static function getModelLabel(): string
    {
        return __('filament-user::resources/user.navigation.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-user::resources/user.navigation.label');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-user::resources/user.navigation.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return UserPlugin::current()->getNavigationGroup();
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Cache::rememberForever(UserObserver::CACHE_KEY, fn () => static::getModel()::query()->count());
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
