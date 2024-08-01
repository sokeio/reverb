<?php

namespace SokeioModule\Reverb;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Manager;
use Laravel\Reverb\Contracts\ApplicationProvider;
use SokeioModule\Reverb\Models\App;

class ReverbManager extends Manager
{
    /**
     * Create an instance of the configuration driver.
     */
    public function createConfigDriver(): ApplicationProvider
    {
        Log::info('createConfigDriver');
        return new ModelApplicationProvider(App::class);
    }
    /**
     * Get the default driver name.
     */
    public function getDefaultDriver(): string
    {
        return $this->config->get('reverb.apps.provider', 'config');
    }
}
