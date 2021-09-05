<?php

declare(strict_types=1);

namespace App\Vocabular\Messages;

use App\Vocabular\Templates;
use App\Vocabular\User\Information;
use BotMan\BotMan\BotMan;

final class Repeating implements Message
{
    private Templates\RepeatWord $repeatWordTemplate;
    private BotMan $botMan;
    private Information $userInformation;

    /**
     * @param Templates\RepeatWord $repeatWordTemplate
     * @param BotMan $botMan
     * @param Information $userInformation
     */
    public function __construct(Templates\RepeatWord $repeatWordTemplate, BotMan $botMan, Information $userInformation)
    {
        $this->repeatWordTemplate = $repeatWordTemplate;
        $this->botMan = $botMan;
        $this->userInformation = $userInformation;
    }

    public function send(): void
    {
        $this->botMan->say(
            $this->repeatWordTemplate->asQuestion(),
            $this->userInformation->userId(),
            $this->userInformation->botDriverClass()
        );
    }
}
