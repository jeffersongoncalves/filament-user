<?php

namespace JeffersonGoncalves\Filament\User;

use Filament\Contracts\Plugin;
use Filament\Panel;
use JeffersonGoncalves\Filament\User\Resources\Users\UserResource;

class UserPlugin implements Plugin
{
    /** @var class-string<UserResource> */
    protected string $resource = UserResource::class;

    protected string $impersonateGuard = 'web';

    protected string $impersonateRedirectTo = '/app';

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
}
