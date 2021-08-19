<?php

declare(strict_types=1);

namespace App\Vocabular;

use BotMan\BotMan\Storages\Storage;

final class VocabularyStorage
{
    private const STORAGE_KEY =  'wordsForRepeat';
    private Storage $storage;

    /**
     * @param Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function vocabulary(): array
    {
        return $this->storage->get(self::STORAGE_KEY) ?? [];
    }

    public function save(array $vocabulary): void
    {
        $this->storage->save([
            self::STORAGE_KEY => $vocabulary
        ]);
    }
}
