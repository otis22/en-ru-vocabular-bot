<?php

declare(strict_types=1);

namespace Tests\Unit\Vocabular\User;

use App\Vocabular\User\Vocabulary;
use App\Vocabular\User\VocabularyIsEmptyException;
use App\Vocabular\Word;
use App\Vocabular\WordForRepeat;
use Tests\TestCase;

final class VocabularyTest extends TestCase
{
    public function testSortVocabularyByLastRepeatDate(): void
    {
        $sut = new Vocabulary(
            [
                new WordForRepeat(
                    new Word('fresher2'),
                    time(),
                    time() + 200,
                    0
                ),
                new WordForRepeat(
                    new Word('older'),
                    time(),
                    time(),
                    0
                ),
                new WordForRepeat(
                    new Word('fresher'),
                    time(),
                    time() + 100,
                    0
                ),
            ]
        );
        $this->assertEquals(
            'older',
            $sut->asArray()['vocabulary'][0]['word']
        );
    }

    public function testWordForRepeatGetOneWord(): void
    {
        $sut = new Vocabulary(
            [
                new WordForRepeat(
                    new Word('test'),
                    time(),
                    time(),
                    4
                )
            ]
        );
        $this->assertEquals(
            'test',
            $sut->wordForRepeat()->asArray()['word']
        );
    }

    public function testWordForRepeatWillRemoveLastRepeatedWord(): void
    {
        $sut = new Vocabulary(
            [
                new WordForRepeat(
                    new Word('test'),
                    time(),
                    time(),
                    5
                )
            ]
        );
        $this->expectException(VocabularyIsEmptyException::class);
        $sut->wordForRepeat();
    }

    public function testWordForRepeatWillRemoveLastRepeatedWordAndReturnTheNext(): void
    {
        $sut = new Vocabulary(
            [
                new WordForRepeat(
                    new Word('willRemove'),
                    time(),
                    time(),
                    5
                ),
                new WordForRepeat(
                    new Word('test'),
                    time(),
                    time() + 100,
                    0
                )
            ]
        );
        $this->assertEquals(
            'test',
            $sut->wordForRepeat()->asArray()['word']
        );
        $this->assertEquals(
            1,
            count($sut->asArray()['vocabulary'])
        );
    }

    public function testSortVocabularyLastUpdateByLastRepeatDate(): void
    {
        $sut = new Vocabulary(
            [
                new WordForRepeat(
                    new Word('fresher'),
                    1631193205,
                    1631193205, // 2021-09-09
                    0
                ),
                new WordForRepeat(
                    new Word('older'),
                    1631153205,
                    1631153205, //2021-09-08
                    0
                )
            ]
        );
        $this->assertEquals(
            "2021-09-09",
            $sut->lastUpdateDate()->format("Y-m-d")
        );
    }
}
