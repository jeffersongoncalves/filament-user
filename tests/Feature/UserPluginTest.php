<?php

use Filament\Facades\Filament;
use Filament\Panel;
use Illuminate\Support\Facades\Hash;
use JeffersonGoncalves\Filament\User\Facades\PanelAccess;
use JeffersonGoncalves\Filament\User\Pages\Auth\Login;
use JeffersonGoncalves\Filament\User\Resources\Users\Pages\CreateUser;
use JeffersonGoncalves\Filament\User\Resources\Users\Pages\ListUsers;
use JeffersonGoncalves\Filament\User\Resources\Users\UserResource;
use JeffersonGoncalves\Filament\User\Tests\Fixtures\CustomUserResource;
use JeffersonGoncalves\Filament\User\Tests\Fixtures\User;
use JeffersonGoncalves\Filament\User\UserPlugin;
use Livewire\Livewire;

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('app'));
});

it('registers the user resource on the panel', function () {
    expect(Filament::getPanel('app')->getResources())->toContain(UserResource::class)
        ->and(UserResource::getModel())->toBe(User::class);
});

it('serves the resource under /users', function () {
    expect(UserResource::getUrl('index'))->toEndWith('/app/users');
});

it('lets the app swap in its own resource and pages follow it', function () {
    $plugin = UserPlugin::make()->resource(CustomUserResource::class);
    $panel = Panel::make()->id('custom')->plugin($plugin);

    expect($panel->getResources())->toContain(CustomUserResource::class)
        ->not->toContain(UserResource::class);

    Filament::setCurrentPanel($panel);

    expect(ListUsers::getResource())->toBe(CustomUserResource::class);
});

it('denies the admin panel and allows others', function () {
    $user = User::factory()->make();

    expect($user->canAccessPanel(Panel::make()->id('admin')))->toBeFalse()
        ->and($user->canAccessPanel(Panel::make()->id('app')))->toBeTrue()
        ->and($user->canImpersonate())->toBeFalse();
});

it('denies panel access to inactive users', function () {
    $user = User::factory()->inactive()->make();

    expect($user->canAccessPanel(Panel::make()->id('app')))->toBeFalse();
});

it('kicks a logged-in user out once deactivated', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->get(UserResource::getUrl('index'))->assertOk();

    $user->update(['status' => false]);

    $this->get(UserResource::getUrl('index'))->assertForbidden();
});

it('reads panel access rules from config', function () {
    config([
        'filament-user.panel_access.denied_panels' => ['app'],
        'filament-user.panel_access.require_active_status' => false,
    ]);

    $user = User::factory()->inactive()->make();

    expect($user->canAccessPanel(Panel::make()->id('app')))->toBeFalse()
        ->and($user->canAccessPanel(Panel::make()->id('admin')))->toBeTrue();
});

it('lets the app replace the panel access check through the facade', function () {
    PanelAccess::using(fn (User $user, Panel $panel): bool => $panel->getId() === 'admin');

    $user = User::factory()->make();

    expect($user->canAccessPanel(Panel::make()->id('admin')))->toBeTrue()
        ->and($user->canAccessPanel(Panel::make()->id('app')))->toBeFalse();

    PanelAccess::using(null);

    expect($user->canAccessPanel(Panel::make()->id('app')))->toBeTrue();
});

it('lists users', function () {
    $users = User::factory()->count(3)->create();
    $this->actingAs($users->first());

    Livewire::test(ListUsers::class)->assertCanSeeTableRecords($users);
});

it('creates a user with a hashed password', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(CreateUser::class)
        ->fillForm([
            'status' => true,
            'name' => 'Jane',
            'email' => 'jane@example.com',
            'password' => 'secret123',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $user = User::query()->where('email', 'jane@example.com')->sole();

    expect(Hash::check('secret123', $user->password))->toBeTrue();
});

it('only lets active users log in', function () {
    User::factory()->create(['email' => 'on@example.com', 'password' => 'secret123']);
    User::factory()->inactive()->create(['email' => 'off@example.com', 'password' => 'secret123']);

    Livewire::test(Login::class)
        ->fillForm(['email' => 'off@example.com', 'password' => 'secret123'])
        ->call('authenticate')
        ->assertHasFormErrors(['email']);

    $this->assertGuest();

    Livewire::test(Login::class)
        ->fillForm(['email' => 'on@example.com', 'password' => 'secret123'])
        ->call('authenticate')
        ->assertHasNoFormErrors();

    $this->assertAuthenticated();
});
