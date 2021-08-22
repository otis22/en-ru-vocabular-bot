<?php

declare(strict_types=1);

namespace App\Http\Controllers;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Storages\Storage;
use Otis22\Reverso\Context;
use App\Vocabular\Word;
use App\Vocabular\Templates\TranslationAnswer;
use App\Vocabular\Translation;
use App\Vocabular\User;

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
            $bot->reply(get_class($bot->userStorage()));
            $this->saveUserInfo($bot);
            $this->addWordToVocabulary($word, $bot->userStorage());
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

    private function saveUserInfo(BotMan $bot): void
    {
        User\Information::fromBotInfo($bot)
            ->save($bot->userStorage());
    }

    private function addWordToVocabulary(Word $word, Storage $storage): void
    {
        User\Vocabulary::fromStorage($storage)
            ->add($word)
            ->save($storage);
    }
}
