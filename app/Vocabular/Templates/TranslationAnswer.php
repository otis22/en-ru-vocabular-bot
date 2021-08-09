<?php

declare(strict_types=1);

namespace App\Vocabular\Templates;

use App\Vocabular\Translation;
use ElegantBro\Interfaces\Stringify;

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
        return "Перевод: {$this->translation->word()}."
            . " Синонимы: {$this->translation->synonyms()}";
    }
}
