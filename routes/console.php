<?php

use BotMan\BotMan\Storages\Drivers\RedisStorage;
use Illuminate\Foundation\Inspiring;
use App\Vocabular\User;
use App\Vocabular\UserStorage;
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('hello', function (){
    echo "Hello world";
})->describe('Hello world');


Artisan::command('repeating', function (){
    $bot = resolve('botman');
    $collectionsOfUsers = $bot->userStorage()->all();
    foreach ($collectionsOfUsers as $userData) {
        $userInformation = User\Information::fromArray($userData->get('information'));
        $userStorage = UserStorage::fromUserInformation($userInformation);
        $repeatWord = $userStorage->repeatWord();
        //var_dump($userData->get('vocabulary'));
        var_dump($repeatWord->asArray());
    }
})->describe('Run repeating words for all users');