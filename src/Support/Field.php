<?php

namespace CraigPaul\Blitz\Support;

use JsonSerializable;

class Field implements JsonSerializable
{
    /**
     * Create a new Field instance.
     *
     * @param string|null $description
     * @param string $label
     * @param string $name
     * @param \CraigPaul\Blitz\Support\Option[] $options
     * @param string|null $placeholder
     * @param \CraigPaul\Blitz\Support\FieldType $type
     */
    public function __construct(
        public readonly ?string $description,
        public readonly string $label,
        public readonly string $name,
        public readonly array $options = [],
        public readonly ?string $placeholder,
        public readonly FieldType $type,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return [
            'description' => $this->description,
            'label' => $this->label,
            'name' => $this->name,
            'options' => $this->options,
            'placeholder' => $this->placeholder,
            'type' => $this->type,
        ];
    }

    /**
     * Create a new Field instance with a type of select.
     *
     * @param string|null $description
     * @param string $label
     * @param string $name
     * @param \CraigPaul\Blitz\Support\Option[] $options
     * @param string|null $placeholder
     *
     * @return static
     */
    public static function select(?string $description = null, string $label, string $name, array $options, ?string $placeholder): static
    {
        return new static(
            description: $description,
            label: $label,
            name: $name,
            options: $options,
            placeholder: $placeholder,
            type: FieldType::Select,
        );
    }
}
