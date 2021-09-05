<?php

declare(strict_types=1);

namespace App\Vocabular\Templates;

use App\Vocabular\WordForRepeat;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

final class RepeatWord
{
    private WordForRepeat $wordForRepeat;

    /**
     * @param WordForRepeat $wordForRepeat
     */
    public function __construct(WordForRepeat $wordForRepeat)
    {
        $this->wordForRepeat = $wordForRepeat;
    }

    public function asQuestion(): Question
    {
        return Question::create(
                $this->wordForRepeat->parsedTemplate(
                    "Как перевести слово %s на русский язык?"
                )
            )
            ->addButton(
                Button::create('Не помню')
                    ->value(
                        $this->wordForRepeat->parsedTemplate(
                            'NEED_REPEAT_WORD_%s'
                        )
                    )
            );
    }

}
