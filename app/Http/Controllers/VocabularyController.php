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
            if (!$this->isRepeatingWord()) {
                UserStorage::fromBotMan($bot)
                    ->addWordToVocabulary($word);
            }
        } catch (\Throwable $exception) {
            error_log('Somethings went wrong: ' . $exception->getMessage());
            $bot->reply("Я понимаю только слова на английском языке. Напишите одно слово на английском и я переведу. Я буду напоминать вам слова, которые для вас переводил.");
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
