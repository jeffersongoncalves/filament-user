<?php

namespace JeffersonGoncalves\Filament\User\Resources;

use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use JeffersonGoncalves\Filament\User\Models\User;
use JeffersonGoncalves\Filament\User\Resources\UserResource\Pages\CreateUser;
use JeffersonGoncalves\Filament\User\Resources\UserResource\Pages\EditUser;
use JeffersonGoncalves\Filament\User\Resources\UserResource\Pages\ListUsers;
use JeffersonGoncalves\Filament\User\Resources\UserResource\Pages\ViewUser;
use JeffersonGoncalves\Filament\User\Resources\UserResource\Schemas\UserForm;
use JeffersonGoncalves\Filament\User\Resources\UserResource\Schemas\UserInfolist;
use JeffersonGoncalves\Filament\User\Resources\UserResource\Tables\UsersTable;
use JeffersonGoncalves\Filament\User\UserPlugin;
use JeffersonGoncalves\User\Observers\UserObserver;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

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

    public static function form(Form $form): Form
    {
        return UserForm::configure($form);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return UserInfolist::configure($infolist);
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
