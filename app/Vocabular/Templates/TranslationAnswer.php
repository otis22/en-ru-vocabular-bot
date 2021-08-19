<?php

declare(strict_types=1);

namespace App\Vocabular\Templates;

use App\Vocabular\Translation;
use ElegantBro\Interfaces\Stringify;
use SebastianBergmann\CodeCoverage\Report\PHP;

final class TranslationAnswer implements Stringify
{
    private Translation $translation;

    /**
     * @param Translation $translation
     */
    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    /**
     * @return string
     */
    public function asString(): string
    {
        return "Перевод: {$this->translation->word()}." . PHP_EOL
            . "Синонимы: {$this->translation->synonyms()}" . PHP_EOL
            . "Пример использования: " . PHP_EOL
            . "En - {$this->translation->example()['en']}" . PHP_EOL
            . "Ru - {$this->translation->example()['ru']}";
    }
}
