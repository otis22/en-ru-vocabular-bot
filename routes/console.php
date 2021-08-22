<?php

use Illuminate\Foundation\Inspiring;

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
    foreach ($collectionsOfUsers as $userStorage) {
        var_dump($userStorage->get('vocabulary'));
    }

})->describe('Run repeating words for all users');