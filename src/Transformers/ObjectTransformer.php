<?php

namespace JesseSchutt\TokenReplacer\Transformers;

use JesseSchutt\TokenReplacer\Contracts\Transformer;
use JesseSchutt\TokenReplacer\Exceptions\InvalidTransformerOptionsException;

class ObjectTransformer implements Transformer
{
    public function __construct(protected mixed $object) {}

    /**
     * @throws InvalidTransformerOptionsException
     */
    public function process(string $options): string
    {
        if (! $options) {
            throw new InvalidTransformerOptionsException('Object transformers option required.');
        }

        return property_exists($this->object, $options)
            ? $this->object->{$options}
            : '';
    }
}
