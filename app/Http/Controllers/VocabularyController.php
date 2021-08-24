<?php

declare(strict_types=1);

namespace App\Http\Controllers;
use App\Vocabular\UserStorage;
use BotMan\BotMan\BotMan;
use Otis22\Reverso\Context;
use App\Vocabular\Word;
use App\Vocabular\Templates\TranslationAnswer;
use App\Vocabular\Translation;

final class VocabularyController extends Controller
{
    public function newWord(BotMan $bot, string $userInput): void
    {
        try {
            $word = new Word($userInput);
            $bot->reply(
                (
                new TranslationAnswer(
                    new Translation(
                        $this->context($word)
                    )
                )
                )->asString()
            );
            UserStorage::fromBotMan($bot)
                ->addWordToVocabulary($word);
        } catch (\Throwable $exception) {
            $bot->reply('Somethings went wrong: ' . $exception->getMessage());
        }
    }

    private function context(Word $word): Context
    {
        return Context::fromLanguagesAndWord(
            "en",
            "ru",
            $word->asString()
        );
    }
}
