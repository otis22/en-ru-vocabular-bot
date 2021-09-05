<?php

declare(strict_types=1);

namespace App\Vocabular\User;

use BotMan\BotMan\BotMan;
use BotMan\Drivers\Telegram\TelegramDriver;
use BotMan\Drivers\VK\VkCommunityCallbackDriver;
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
            (string) $bot->getUser()->getId(),
            (string) $bot->getDriver()->getName(),
            (string) $bot->getMessage()->getSender()
        );
    }

    public static function fromArray(array $information): self
    {
        return new self(
            (string) $information['userId'],
            (string) $information['driver'],
            (string) $information['sender']
        );
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function botDriverClass(): string
    {
        if ($this->driver === 'VkCommunityCallback') {
            return VkCommunityCallbackDriver::class;
        }
        if ($this->driver === 'Telegram') {
            return TelegramDriver::class;
        }
        throw new \Exception("Driver " . $this->driver . " is unknown");
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
