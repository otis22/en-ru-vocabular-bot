<?php

$botman = resolve('botman');

$botman->hears('{userInput}', 'App\Http\Controllers\VocabularyController@newWord');

$botman->hears('mydata', function (\BotMan\BotMan\BotMan $bot) {
    $message = sprintf("userId: %s, driver: %s", $bot->getUser()->getId(), get_class($bot->getDriver()));
    $bot->reply($message);
});