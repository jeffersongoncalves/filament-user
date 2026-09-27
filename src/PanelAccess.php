<?php

namespace JeffersonGoncalves\Filament\User;

use Closure;
use Filament\Panel;
use Illuminate\Database\Eloquent\Model;

class PanelAccess
{
    /** @var (Closure(Model, Panel): bool)|null */
    protected ?Closure $using = null;

    /**
     * Replace the config-driven check with a custom one. Pass null to restore it.
     *
     * @param  (Closure(Model, Panel): bool)|null  $callback
     */
    public function using(?Closure $callback): static
    {
        $this->using = $callback;

        return $this;
    }

    public function check(Model $user, Panel $panel): bool
    {
        if ($this->using) {
            return (bool) ($this->using)($user, $panel);
        }

        /** @var array<int, string> $deniedPanels */
        $deniedPanels = config('filament-user.panel_access.denied_panels', ['admin']);

        if (in_array($panel->getId(), $deniedPanels, true)) {
            return false;
        }

        if (! config('filament-user.panel_access.require_active_status', true)) {
            return true;
        }

        return (bool) $user->getAttribute('status');
    }
}
