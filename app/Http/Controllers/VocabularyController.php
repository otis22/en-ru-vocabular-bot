<?php

declare(strict_types=1);

namespace App\Http\Controllers;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Storages\Storage;
use Otis22\Reverso\Context;
use App\Vocabular\Word;
use App\Vocabular\Templates\TranslationAnswer;
use App\Vocabular\Translation;
use App\Vocabular\UserVocabulary;
use App\Vocabular\VocabularyStorage;

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
            $this->addToUserVocabulary($word, $bot->userStorage());
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

    private function addToUserVocabulary(Word $word, Storage $storage): void
    {
        $userVocabulary = new UserVocabulary(
            new VocabularyStorage($storage)
        );
        $userVocabulary->add($word);
    }

}
