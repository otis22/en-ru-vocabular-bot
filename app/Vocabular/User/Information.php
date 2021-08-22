<?php

declare(strict_types=1);

namespace App\Vocabular\User;

use BotMan\BotMan\BotMan;
use ElegantBro\Interfaces\Arrayee;

final class Information implements Arrayee
{
    private string $userId;
    private string $driver;
    private string $sender;

    /**
     * @param string $userId
     * @param string $driver
     * @param string $sender
     */
    public function __construct(string $userId, string $driver, string $sender)
    {
        $this->userId = $userId;
        $this->driver = $driver;
        $this->sender = $sender;
    }


    public static function fromBotInfo(BotMan $bot): self
    {
        return new self(
            strval(
                $bot->getUser()->getId()
            ),
            $bot->getDriver()->getName(),
            $bot->getMessage()->getSender()
        );
    }

    public static function fromArray(array $information): self
    {
        return new self(
            $information['userId'],
            $information['driver'],
            $information['sender']
        );
    }

    public function asArray(): array
    {
        return [
            'information' => [
                'userId' => $this->userId,
                'driver' => $this->driver,
                'sender' => $this->sender
            ]
        ];
    }
}
