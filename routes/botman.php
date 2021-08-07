<?php

use App\Http\Controllers\BotManController;
use Otis22\Reverso\Context;
use App\Vocabular\Word;

$botman = resolve('botman');

$botman->hears('{userInput}', function ($bot, $userInput) {
    try {
        $word = new Word($userInput);
        $context = Context::fromLanguagesAndWord(
            "en",
            "ru",
            $word->asString()
        );
        $bot->reply('<b>Перевод: </b>' . $context->firstInDictionary());
    } catch (\Throwable $exception) {
        $bot->reply('Somethings went wrong: ' . $exception->getMessage());
    }
});
