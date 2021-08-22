<?php

declare(strict_types=1);

namespace App\Vocabular;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Storages\Storage;
use App\Vocabular\User;

final class UserStorage
{
    private Storage $storage;
    private User\Information $information;
    private User\Vocabulary $vocabulary;

    /**
     * @param Storage $storage
     * @param User\Information $information
     * @param User\Vocabulary $vocabulary
     */
    public function __construct(Storage $storage, User\Information $information, User\Vocabulary $vocabulary)
    {
        $this->storage = $storage;
        $this->information = $information;
        $this->vocabulary = $vocabulary;
    }

    public static function fromBotMan(BotMan $botMan): self
    {
        return new self(
            $botMan->userStorage(),
            User\Information::fromBotInfo($botMan),
            User\Vocabulary::fromStorage($botMan->userStorage())
        );
    }

    public function addWordToVocabulary(Word $word): self
    {
        $this->vocabulary = $this->vocabulary->add($word);
        return $this;
    }

    public function save(): void
    {
        $this->storage->save(
            array_merge_recursive(
                $this->vocabulary->asArray(),
                $this->information->asArray()
            )
        );
    }
}
