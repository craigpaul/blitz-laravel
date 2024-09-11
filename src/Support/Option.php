<?php

namespace CraigPaul\Blitz\Support;

use JsonSerializable;

class Option implements JsonSerializable
{
    /**
     * Create a new Option instance.
     *
     * @param string $text
     * @param bool|int|float|string|null $value
     *
     * @return void
     */
    public function __construct(
        public readonly string $text,
        public readonly bool|int|float|string|null $value,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return [
            'text' => $this->text,
            'value' => $this->value,
        ];
    }
}
