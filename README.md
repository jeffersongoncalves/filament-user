<div class="filament-hidden">

![Filament User](https://raw.githubusercontent.com/jeffersongoncalves/filament-user/3.x/art/jeffersongoncalves-filament-user.png)

</div>

# Filament User

Filament `User` model, `UserResource`, status-aware Login page and plugin used by the jeffersongoncalves starter kits. Built on [laravel-user](https://github.com/jeffersongoncalves/laravel-user).

## Compatibility

| Branch | Filament | Package version |
|--------|----------|-----------------|
| 1.x | 3.x | ^1.0 |
| 2.x | 4.x | ^2.0 |
| 3.x | 5.x | ^3.0 |

## Installation

```bash
composer require jeffersongoncalves/filament-user
```

## Usage

### Model

```php
namespace App\Models;

use JeffersonGoncalves\Filament\User\Models\User as BaseUser;

class User extends BaseUser
{
    // add traits (e.g. HasTeamsFilament), relations or overrides here
}
```

It implements `FilamentUser` and `HasAvatar` (reads the `filament-edit-profile.avatar_column`).

### Panel access

By default a user can enter every panel except `admin`, and only while `status = true`. Filament re-checks this on every request, so deactivating a user also ends their open sessions and remember-me logins.

Tune the rules in the config file:

```bash
php artisan vendor:publish --tag="filament-user-config"
```

```php
// config/filament-user.php
'panel_access' => [
    'denied_panels' => ['admin'],
    'require_active_status' => true,
],
```

Or replace the check entirely from a service provider (e.g. `AppServiceProvider::boot()`):

```php
use Filament\Panel;
use JeffersonGoncalves\Filament\User\Facades\PanelAccess;

PanelAccess::using(fn (User $user, Panel $panel): bool => $user->status && $panel->getId() === 'app');
```

### Panel

```php
use JeffersonGoncalves\Filament\User\Pages\Auth\Login;
use JeffersonGoncalves\Filament\User\UserPlugin;

// Panel where users sign in: only active users (status = true) can log in
$panel->login(Login::class);

// Panel that manages users (usually the admin panel)
$panel->plugins([
    UserPlugin::make()
        ->impersonate(guard: 'web', redirectTo: '/app'),
]);
```

The resource uses the model from `auth.providers.users.model`, so it always works with `App\Models\User`.

Other plugin options:

```php
UserPlugin::make()
    ->withoutImpersonation()       // hide the impersonate action (table, View and Edit pages)
    ->navigationGroup('Access');   // custom navigation group; false = no group
```

### Translations

Labels ship in `en`, `pt_BR` and `es` under the `filament-user::user.*` namespace. To change them, publish and edit:

```bash
php artisan vendor:publish --tag="filament-user-translations"
```

### Extending

Extend the resource and hand it to the plugin. The resource pages follow the plugin, so there is nothing else to copy:

```php
use JeffersonGoncalves\Filament\User\Resources\UserResource\Schemas\UserForm;
use JeffersonGoncalves\Filament\User\Resources\UserResource;

class MyUserForm extends UserForm
{
    public static function components(): array
    {
        return [
            ...parent::components(),
            TextInput::make('phone'),
        ];
    }
}

class MyUserResource extends UserResource
{
    public static function form(Form $form): Form
    {
        return MyUserForm::configure($form);
    }
}

UserPlugin::make()->resource(MyUserResource::class);
```

`UserInfolist::components()` and `UsersTable::columns()` can be extended the same way.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jefferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
