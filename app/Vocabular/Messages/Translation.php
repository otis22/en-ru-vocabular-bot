<?php

declare(strict_types=1);

namespace App\Vocabular\Messages;

use App\Vocabular\Templates\TranslationAnswer;
use BotMan\BotMan\BotMan;

final class Translation implements Message
{
    private TranslationAnswer $answer;
    private BotMan $botMan;

    /**
     * @param TranslationAnswer $answer
     * @param BotMan $botMan
     */
    public function __construct(TranslationAnswer $answer, BotMan $botMan)
    {
        $this->answer = $answer;
        $this->botMan = $botMan;
    }

    public function send(): void
    {
        $this->botMan->reply($this->answer->asString());
    }
}
