<?php

namespace JeffersonGoncalves\Filament\User\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use JeffersonGoncalves\Filament\AdditionalInformation\FilamentAdditionalInformationServiceProvider;
use JeffersonGoncalves\Filament\User\Tests\Fixtures\TestPanelProvider;
use JeffersonGoncalves\Filament\User\Tests\Fixtures\User;
use JeffersonGoncalves\Filament\User\UserServiceProvider;
use JeffersonGoncalves\User\UserServiceProvider as LaravelUserServiceProvider;
use Lab404\Impersonate\ImpersonateServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use STS\FilamentImpersonate\FilamentImpersonateServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            BladeIconsServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            LivewireServiceProvider::class,
            SupportServiceProvider::class,
            FormsServiceProvider::class,
            TablesServiceProvider::class,
            ActionsServiceProvider::class,
            InfolistsServiceProvider::class,
            NotificationsServiceProvider::class,
            WidgetsServiceProvider::class,
            FilamentServiceProvider::class,
            ImpersonateServiceProvider::class,
            FilamentImpersonateServiceProvider::class,
            FilamentAdditionalInformationServiceProvider::class,
            LaravelUserServiceProvider::class,
            UserServiceProvider::class,
            TestPanelProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
        $app['config']->set('auth.providers.users.model', User::class);
    }

    protected function defineDatabaseMigrations(): void
    {
        (include __DIR__.'/../vendor/jeffersongoncalves/laravel-user/database/migrations/create_users_table.php.stub')->up();
    }
}
