<?php

declare(strict_types=1);

namespace App\Vocabular;

use Otis22\Reverso\Context;

final class Translation
{
    private Context $context;

    /**
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function word(): string
    {
        return $this->context->firstInDictionary();
    }

    public function synonyms(): string
    {
        return join(
            ', ',
            array_slice(
                $this->context->dictionary(),
                0,
                3
            )
        );
    }
}
