<?php

declare(strict_types=1);

namespace App\Vocabular;

use BotMan\BotMan\Storages\Storage;

final class UserVocabulary
{
    private VocabularyStorage $storage;

    /**
     * @param VocabularyStorage $storage
     */
    public function __construct(VocabularyStorage $storage)
    {
        $this->storage = $storage;
    }

    public function add(Word $word): void
    {
        $this->storage->save(
            array_merge(
                $this->storage->vocabulary(),
                WordForRepeat::fromWord($word)->asArray()
            )
        );
    }
}
