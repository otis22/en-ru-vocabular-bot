<?php

declare(strict_types=1);

namespace App\Vocabular;

use ElegantBro\Interfaces\Stringify;

final class Word implements Stringify
{
    private string $word;

    /**
     * @param string $word
     */
    public function __construct(string $word)
    {
        $this->word = $word;
    }

    private function isNotEnglish(): bool
    {
        return strlen($this->word) !== strlen(utf8_decode($this->word));
    }

    private function isNotASingleWord(): bool
    {
        return strpos(
            strtolower(trim($this->word)),
            ' '
        ) !== false;
    }

    public function asString(): string
    {
        if ($this->isNotASingleWord()) {
            throw new \InvalidArgumentException("Bot can translate a only single word");
        }
        if ($this->isNotEnglish()) {
            throw new \InvalidArgumentException("Bot work only with english words");
        }
        return $this->word;
    }
}
