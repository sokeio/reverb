<?php

namespace SokeioModule\Reverb;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Laravel\Reverb\Application;
use Laravel\Reverb\Contracts\ApplicationProvider;
use Laravel\Reverb\Exceptions\InvalidApplication;

class ModelApplicationProvider implements ApplicationProvider
{
    /**
     * Create a new config provider instance.
     */
    public function __construct(private $model)
    {
        //
    }
    public function query()
    {
        return app($this->model)->query();
    }
    /**
     * Get all of the configured applications as Application instances.
     *
     * @return \Illuminate\Support\Collection<\Laravel\Reverb\Application>
     */
    public function all(): Collection
    {
        return $this->query()->get()->map(function ($app) {
            return $this->findById($app->id);
        });
    }

    /**
     * Find an application instance by ID.
     *
     * @throws \Laravel\Reverb\Exceptions\InvalidApplication
     */
    public function findById(string $id): Application
    {
        return $this->find('id', $id);
    }

    /**
     * Find an application instance by key.
     *
     * @throws \Laravel\Reverb\Exceptions\InvalidApplication
     */
    public function findByKey(string $key): Application
    {
        return $this->find('key', $key);
    }

    /**
     * Find an application instance.
     *
     * @throws \Laravel\Reverb\Exceptions\InvalidApplication
     */
    public function find(string $key, mixed $value): Application
    {
        $app = $this->query()->where($key, $value)->first();

        if (!$app) {
            throw new InvalidApplication;
        }

        return new Application(
            $app['id'],
            $app['key'],
            $app['secret'],
            $app['ping_interval'],
            $app['allowed_origins'],
            $app['max_message_size'],
            $app['options'] ?? [],
        );
    }
}
