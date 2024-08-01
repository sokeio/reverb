<?php

namespace SokeioModule\Reverb;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Laravel\Reverb\ApplicationManager;
use Laravel\Reverb\Contracts\ApplicationProvider;
use Sokeio\Laravel\ServicePackage;
use Sokeio\Concerns\WithServiceProvider;
use Sokeio\Facades\Menu;
use Sokeio\Facades\Platform;
use SokeioModule\Reverb\Models\App;

class ReverbServiceProvider extends ServiceProvider
{
    use WithServiceProvider;

    public function configurePackage(ServicePackage $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         */
        $package
            ->name('reverb')
            ->hasConfigFile()
            ->hasViews()
            ->hasHelpers()
            ->hasAssets()
            ->hasTranslations()
            ->runsMigrations();
    }
    public function packageRegistered()
    {

        // packageRegistered
        Platform::ready(function () {
            if (sokeioIsAdmin()) {
                Menu::Register(function () {
                    menuAdmin()
                        ->route('reverb.apps', __('Applications'), '<i class="ti ti-apps fs-2"></i>', [], '', 2);
                });
            }
        });
    }
    private function bootGate()
    {
        if (!$this->app->runningInConsole()) {
            addFilter(PLATFORM_PERMISSION_CUSTOME, function ($prev) {
                return [
                    ...$prev
                ];
            });
        }
    }
    public function packageBooted()
    {
        $this->app->singleton(ApplicationManager::class, function ($app) {
            Log::debug('booting reverb');
            return new ReverbManager($app);
        });
        $this->bootGate();
    }
}
