<?php

namespace SokeioModule\Reverb;

use Illuminate\Support\Facades\Log;
use Laravel\Reverb\ApplicationManager;
use Laravel\Reverb\ConfigApplicationProvider;

class ReverbManager extends ApplicationManager
{
    /**
     * Create an instance of the configuration driver.
     */
    public function createConfigDriver(): ConfigApplicationProvider
    {
        return new ConfigApplicationProvider(
            collect($this->config->get('reverb.apps.apps', []))
        );
    }
}
