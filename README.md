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

It implements `FilamentUser` (every panel except `admin`) and `HasAvatar` (reads the `filament-edit-profile.avatar_column`).

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

### Extending

Extend the resource and hand it to the plugin. The resource pages follow the plugin, so there is nothing else to copy:

```php
use JeffersonGoncalves\Filament\User\Resources\Users\Schemas\UserForm;
use JeffersonGoncalves\Filament\User\Resources\Users\UserResource;

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
    public static function form(Schema $schema): Schema
    {
        return MyUserForm::configure($schema);
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
