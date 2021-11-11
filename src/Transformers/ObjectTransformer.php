<?php

namespace HollyIT\TokenReplace\Transformers;

use HollyIT\TokenReplace\Contracts\Transformer;
use HollyIT\TokenReplace\Exceptions\InvalidTransformerOptionsException;
use HollyIT\TokenReplace\TokenReplacer;

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
