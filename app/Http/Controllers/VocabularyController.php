<?php

declare(strict_types=1);

namespace App\Http\Controllers;
use App\Vocabular\UserStorage;
use BotMan\BotMan\BotMan;
use Otis22\Reverso\Context;
use App\Vocabular\Word;
use App\Vocabular\Templates\TranslationAnswer;
use App\Vocabular\Translation;
use App\Vocabular\Messages;

final class VocabularyController extends Controller
{
    public function newWord(BotMan $bot, string $userInput): void
    {
        try {
            $word = $this->word($userInput);
            $message = new Messages\Translation(
                new TranslationAnswer(
                    new Translation(
                        $this->context($word)
                    )
                ),
                $bot
            );
            $message->send();
            UserStorage::fromBotMan($bot)
                ->addWordToVocabulary($word);
        } catch (\Throwable $exception) {
            $bot->reply('Somethings went wrong: ' . $exception->getMessage());
        }
    }

    private function word(string $userInput): Word
    {
        return $this->isRepeatingWord($userInput)
            ? Word::fromButtonValue($userInput)
            : new Word($userInput);
    }

    private function isRepeatingWord($userInput): bool
    {
        return strpos($userInput, 'NEED_REPEAT_WORD_') !== false;
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
