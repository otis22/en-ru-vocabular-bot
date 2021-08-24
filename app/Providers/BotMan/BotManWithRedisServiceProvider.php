<?php

declare(strict_types=1);

namespace App\Providers\BotMan;

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Container\LaravelContainer;
use BotMan\BotMan\Interfaces\StorageInterface;
use BotMan\BotMan\Storages\Drivers\FileStorage;
use BotMan\BotMan\Storages\Drivers\RedisStorage;
use BotMan\BotMan\Storages\Storage;
use Illuminate\Support\ServiceProvider;

class BotManWithRedisServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('botman', function ($app) {
            $botman = BotManFactory::create(
                config('botman', []),
                new LaravelCache(),
                $app->make('request'),
                $this->storage()
            );

            $botman->setContainer(new LaravelContainer($this->app));

            return $botman;
        });
    }

    private function storage(): StorageInterface
    {
        return config('app.env') === 'testing'
                ? new FileStorage(storage_path('botman'))
                : resolve('redisStorage');
    }
}
