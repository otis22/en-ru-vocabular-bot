<?php

namespace Tests\BotMan;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHelloTranslate()
    {
        $messages = $this->bot
            ->receives('Hi')
            ->getMessages();
        $this->assertStringContainsString( 'привет', $messages[0]->getText());
    }
}
