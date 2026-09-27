<?php

namespace JeffersonGoncalves\Filament\User;

use Filament\Contracts\Plugin;
use Filament\Facades\Filament;
use Filament\Panel;
use JeffersonGoncalves\Filament\User\Resources\Users\UserResource;

class UserPlugin implements Plugin
{
    /** @var class-string<UserResource> */
    protected string $resource = UserResource::class;

    protected string $impersonateGuard = 'web';

    protected string $impersonateRedirectTo = '/app';

    protected bool $impersonationEnabled = true;

    protected string|false|null $navigationGroup = null;

    public function getId(): string
    {
        return 'filament-user';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            $this->resource,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    /**
     * The plugin registered on the current panel, or a default instance outside of it.
     */
    public static function current(): static
    {
        return Filament::getCurrentPanel()?->hasPlugin(app(static::class)->getId()) ? static::get() : static::make();
    }

    /**
     * Swap in the app's own resource (usually a subclass of UserResource).
     *
     * @param  class-string<UserResource>  $resource
     */
    public function resource(string $resource): static
    {
        $this->resource = $resource;

        return $this;
    }

    public function getResource(): string
    {
        return $this->resource;
    }

    public function impersonate(string $guard = 'web', string $redirectTo = '/app'): static
    {
        $this->impersonateGuard = $guard;
        $this->impersonateRedirectTo = $redirectTo;

        return $this;
    }

    public function getImpersonateGuard(): string
    {
        return $this->impersonateGuard;
    }

    public function getImpersonateRedirectTo(): string
    {
        return $this->impersonateRedirectTo;
    }

    /**
     * Hide the impersonate action from the table and the View/Edit pages.
     */
    public function withoutImpersonation(bool $condition = true): static
    {
        $this->impersonationEnabled = ! $condition;

        return $this;
    }

    public function isImpersonationEnabled(): bool
    {
        return $this->impersonationEnabled;
    }

    /**
     * Pass false to show the resource outside of any navigation group.
     */
    public function navigationGroup(string|false|null $group): static
    {
        $this->navigationGroup = $group;

        return $this;
    }

    public function getNavigationGroup(): ?string
    {
        if ($this->navigationGroup === false) {
            return null;
        }

        return $this->navigationGroup ?? __('filament-user::resources/user.navigation.group');
    }
}
