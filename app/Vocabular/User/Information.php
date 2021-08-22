<?php

declare(strict_types=1);

namespace App\Vocabular\User;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Storages\Storage;
use ElegantBro\Interfaces\Arrayee;

final class Information implements Arrayee
{
    private string $userId;
    private string $driver;

    /**
     * @param string $userId
     * @param string $driver
     */
    public function __construct(string $userId, string $driver)
    {
        $this->userId = $userId;
        $this->driver = $driver;
    }

    public static function fromBotInfo(BotMan $bot): self
    {
        return new self(
            strval(
                $bot->getUser()->getId()
            ),
            $bot->getDriver()->getName()
        );
    }

    public function asArray(): array
    {
        return [
            'information' => [
                'userId' => $this->userId,
                'driver' => $this->driver
            ]
        ];
    }
}
