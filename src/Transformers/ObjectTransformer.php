<?php

namespace JesseSchutt\TokenReplacer\Transformers;

use JesseSchutt\TokenReplacer\Contracts\Transformer;
use JesseSchutt\TokenReplacer\Exceptions\InvalidTransformerOptionsException;
use JesseSchutt\TokenReplacer\TokenReplacer;

class ObjectTransformer implements Transformer
{
    protected mixed $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    public function process(string $options, TokenReplacer $replacer): string
    {
        if (! $options) {
            throw new InvalidTransformerOptionsException('Object transformers option required.');
        }

        return property_exists($this->object, $options) ? $this->object->{$options} : '';
    }
}
