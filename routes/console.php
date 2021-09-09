<?php

use Illuminate\Foundation\Inspiring;
use App\Vocabular\User;
use App\Vocabular\UserStorage;
use App\Vocabular\Messages;
use App\Vocabular\Templates;

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
    /**
     * @var \BotMan\BotMan\BotMan
     */
    $bot = resolve('botman');
    $collectionsOfUsers = $bot->userStorage()->all();
    foreach ($collectionsOfUsers as $userData) {
        $userInformation = User\Information::fromArray($userData->get('information'));
        $userStorage = UserStorage::fromUserInformation($userInformation);
        try {
            $message = new Messages\Repeating(
                new Templates\RepeatWord(
                    $userStorage->repeatWord()
                ),
                $bot,
                $userInformation
            );
            $message->send();
        } catch (\Throwable $e) {
            $error_message = "Caught exception: " . $e->getMessage()
                . ". For user: " . json_encode($userInformation->asArray());
            error_log($error_message);
            echo $error_message . "\n";
        }
    }
})->describe('Run repeating words for all users');

Artisan::command('statistics', function () {
    /**
     * @var \BotMan\BotMan\BotMan
     */
    $bot = resolve('botman');
    $collections = $bot->userStorage()->all();
    echo "Count of users: " . count($collections);
    echo "\n";
    echo "Real users: " . count(
        array_filter(
            $collections,
            function ($userData) {
                try {
                    User\Information::fromArray(
                        $userData->get('information')
                    )->botDriverClass();
                    return true;
                } catch (\Throwable $exception) {
                    return false;
                }
            }
        )
    );
    echo "\n";
    echo "Count of words " . array_reduce(
        $collections,
        function ($carry, $item) {
            return $carry + count($item->get('vocabulary'));
        }
    );
    echo "\n";
    foreach ($collections as $userData) {
        $userInformation = User\Information::fromArray($userData->get('information'));
        $vocabulary = new User\Vocabulary($userData->get('vocabulary'));
        echo $userInformation->userId() . " has " . count($userData->get('vocabulary')). " words, last update date is " . $vocabulary->lastUpdateDate()->format("d.m.Y");
        echo "\n";
    }
    
});