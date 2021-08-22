<?php

declare(strict_types=1);

namespace App\Vocabular\User;

use App\Vocabular\Word;
use App\Vocabular\WordForRepeat;
use BotMan\BotMan\Storages\Storage;
use ElegantBro\Interfaces\Arrayee;
use Exception;

final class Vocabulary implements Arrayee
{
    /**
     * @var WordForRepeat[]
     */
    private array $vocabulary;

    /**
     * @param WordForRepeat[] $vocabulary
     */
    public function __construct(array $vocabulary)
    {
        $this->vocabulary = $vocabulary;
    }

    public static function fromStorage(Storage $storage): self
    {
        return new self(
            array_map(
                static fn(array $el): WordForRepeat => WordForRepeat::fromArray($el),
                $storage->get('vocabulary') ?? []
            )
        );
    }

    public function add(Word $word): self
    {
        return new self(
            $this->isNeedAddWord($word)
                ? $this->vocabularyWithNewWord($word)
                : $this->vocabularyWithTouchedUserWord($word)
        );
    }

    private function isNeedAddWord(Word $word): bool
    {
        foreach ($this->vocabulary as $wordForRepeat)
        {
            if ($wordForRepeat->isEqual($word))
            {
                return false;
            }
        }
        return true;
    }

    private function vocabularyWithNewWord(Word $word): array
    {
        return array_merge(
            $this->vocabulary,
            [WordForRepeat::fromWord($word)]
        );
    }

    private function vocabularyWithTouchedUserWord(Word $word): array
    {
        return array_map(
            static fn(WordForRepeat $forRepeat): WordForRepeat => $forRepeat->isEqual($word) ? $forRepeat->touch() : $forRepeat,
            $this->vocabulary
        );
    }

    public function asArray(): array
    {
        return [
            'vocabulary' => array_map(
                static fn(WordForRepeat $word): array => $word->asArray()
                , $this->vocabulary
            )
        ];
    }
}
