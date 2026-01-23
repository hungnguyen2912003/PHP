<?php

declare(strict_types=1);

namespace Mckenziearts\Notify;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

final class NotifyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerBladeDirective();
        $this->bootPublishes();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'notify');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'notify');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/notify.php', 'notify');

        $this->app->singleton('notify', fn (Application $app): Notify => $app->make(Notify::class));
    }

    public function registerBladeDirective(): void
    {
        Blade::directive('notifyCss', fn (): string => '<?php echo notifyCss(); ?>');

        Blade::directive('notifyJs', fn (): string => '<?php echo notifyJs(); ?>');
    }

    public function bootPublishes(): void
    {
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/mckenziearts/laravel-notify'),
        ], 'notify-assets');

        $this->publishes([
            __DIR__.'/../config/notify.php' => config_path('notify.php'),
        ], 'notify-config');

        $this->publishes([
            __DIR__.'/../resources/lang' => lang_path('vendor/notify'),
        ], 'notify-lang');
    }
}
