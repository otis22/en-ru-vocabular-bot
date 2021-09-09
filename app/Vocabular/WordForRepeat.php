<?php

declare(strict_types=1);

namespace App\Vocabular;

use App\Vocabular\Exceptions\MaxRepeatedTimesException;
use ElegantBro\Interfaces\Arrayee;

final class WordForRepeat implements Arrayee
{
    private const MAX_REPEATED_TIMES = 5;
    private Word $word;
    private int $createDate;
    private int $lastRepeatDate;
    private int $repeatedTimes;

    /**
     * @param Word $word
     * @param int $createDate
     * @param int $lastRepeatDate
     * @param int $repeatedTimes
     */
    public function __construct(Word $word, int $createDate, int $lastRepeatDate, int $repeatedTimes)
    {
        $this->word = $word;
        $this->createDate = $createDate;
        $this->lastRepeatDate = $lastRepeatDate;
        $this->repeatedTimes = $repeatedTimes;
    }


    /**
     * @param array<string, mixed> $arr
     * @return static
     */
    public static function fromArray(array $arr): self
    {
        return new self(
            new Word($arr['word']),
            $arr['createDate'],
            $arr['lastRepeatDate'],
            $arr['repeatedTimes']
        );
    }

    public static function fromWord(Word $word): self
    {
        return new self(
            $word,
            time(),
            time(),
            0
        );
    }

    public function isEqual(Word $word): bool
    {
        return $word->asString() === $this->word->asString();
    }

    public function isFresher(WordForRepeat $wordForRepeat): int
    {
        return $this->lastRepeatDate <=> $wordForRepeat->asArray()['lastRepeatDate'];
    }

    public function touch(): self
    {
        $repeatedTimesAfterTouch = $this->repeatedTimes + 1;
        if ($repeatedTimesAfterTouch > self::MAX_REPEATED_TIMES) {
            throw new MaxRepeatedTimesException("It's enough! I think you know this word!");
        }
        return new self(
            $this->word,
            $this->createDate,
            time(),
            $repeatedTimesAfterTouch
        );
    }

    public function lastRepeat(): \DateTime
    {
        return date_create()
            ->setTimestamp($this->lastRepeatDate);
    }

    public function parsedTemplate(string $template): string
    {
        return sprintf($template, $this->word->asString());
    }

    public function asArray(): array
    {
        return [
            'word' => $this->word->asString(),
            'createDate' => $this->createDate,
            'lastRepeatDate' => $this->lastRepeatDate,
            'repeatedTimes' => $this->repeatedTimes
        ];
    }
}
