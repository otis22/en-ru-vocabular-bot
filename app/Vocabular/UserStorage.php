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

    public static function fromUserInformation(User\Information $information): self
    {
        $storage = new Storage(resolve('redisStorage'));
        $storage->setPrefix('user_')
            ->setDefaultKey($information->asArray()['informatecho ""ion']['sender']);
        return new self(
            $storage,
            $information,
            User\Vocabulary::fromStorage($storage)
        );
    }

    public function addWordToVocabulary(Word $word): void
    {
        $this->vocabulary = $this->vocabulary->add($word);
        $this->save();
    }

    public function repeatWord(): WordForRepeat
    {
        $wordForRepeat = $this->vocabulary->wordForRepeat();
        $this->save();
        return $wordForRepeat;
    }

    private function save(): void
    {
        $this->storage->save(
            array_merge_recursive(
                $this->vocabulary->asArray(),
                $this->information->asArray()
            )
        );
    }
}
