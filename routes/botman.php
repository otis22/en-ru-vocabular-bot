<?php

use App\Http\Controllers\BotManController;
use Otis22\Reverso\Context;
use App\Vocabular\Word;
use App\Vocabular\Templates\TranslationAnswer;
use App\Vocabular\Translation;

$botman = resolve('botman');

$botman->hears('{userInput}', function ($bot, $userInput) {
    try {
        $word = new Word($userInput);
        $context = Context::fromLanguagesAndWord(
            "en",
            "ru",
            $word->asString()
        );
        $bot->reply(
            (
                new TranslationAnswer(
                   new Translation($context)
                )
            )->asString()
        );
    } catch (\Throwable $exception) {
        $bot->reply('Somethings went wrong: ' . $exception->getMessage());
    }
});
