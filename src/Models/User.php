<?php

namespace JeffersonGoncalves\Filament\User\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Support\Facades\Storage;
use JeffersonGoncalves\Filament\User\Facades\PanelAccess;
use JeffersonGoncalves\User\Models\User as BaseUser;

class User extends BaseUser implements FilamentUser, HasAvatar
{
    public function canAccessPanel(Panel $panel): bool
    {
        return PanelAccess::check($this, $panel);
    }

    public function canImpersonate(): bool
    {
        return false;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        $avatarColumn = config('filament-edit-profile.avatar_column', 'avatar_url');

        return $this->$avatarColumn ? Storage::url($this->$avatarColumn) : null;
    }
}
