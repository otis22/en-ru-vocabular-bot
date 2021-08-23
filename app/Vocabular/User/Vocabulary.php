<?php

declare(strict_types=1);

namespace App\Vocabular\User;

use App\Vocabular\Exceptions\MaxRepeatedTimesException;
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
                , $this->sortedVocabulary()
            )
        ];
    }

    private function sortedVocabulary(): array
    {
        $vocabulary = new \ArrayObject($this->vocabulary);
        $vocabulary->uasort(static fn(WordForRepeat $a, WordForRepeat $b) => $a->isFresher($b));
        return array_values((array) $vocabulary);
    }

    public function wordForRepeat(): WordForRepeat
    {
        if (empty($this->vocabulary)) {
            throw new VocabularyIsEmptyException("Vocabulary is empty. You've learned all words! Please enter new words");
        }
        try {
            $this->vocabulary[0] = $this->vocabulary[0]->touch();
            return $this->vocabulary[0];
        } catch (MaxRepeatedTimesException $exception) {
            unset($this->vocabulary[0]);
            $this->vocabulary = array_values($this->vocabulary);
            return $this->wordForRepeat();
        }
    }
}
