<?php

declare(strict_types=1);

namespace App\Vocabular\Messages;

interface Message
{
    public function send(): void;
}
