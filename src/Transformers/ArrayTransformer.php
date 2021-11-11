<?php

namespace HollyIT\TokenReplace\Transformers;

use HollyIT\TokenReplace\Exceptions\InvalidTransformerOptionsException;
use HollyIT\TokenReplace\TokenReplacer;
use HollyIT\TokenReplace\Contracts\Transformer;

class ArrayTransformer implements Transformer
{
    protected array $inputArray;

    public function __construct(array $inputArray)
    {
        $this->inputArray = $inputArray;
    }

    public function process(string $options, TokenReplacer $replacer): string
    {
        if (! $options) {
            throw new InvalidTransformerOptionsException('ArrayTransformer option required');
        }
        if (array_key_exists($options, $this->inputArray)) {
            return (string) $this->inputArray[$options];
        }

        return '';
    }
}
