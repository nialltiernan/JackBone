<?php

namespace App\Service;

use JetBrains\PhpStorm\Pure;

class EmojiService
{
    private const EMOJIS = ['&#129492;','&#129430;', '&#128301;'];

    #[Pure]
    public function __invoke(): string
    {
        return self::EMOJIS[array_rand(self::EMOJIS)];
    }
}