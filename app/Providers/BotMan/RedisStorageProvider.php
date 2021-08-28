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

class RedisStorageProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('redisStorage', function () {
            return new RedisStorage(
                config('database.redis.default.host'),
                config('database.redis.default.port'),
                config('database.redis.default.password')
            );
        });
    }
}
