<?php

namespace JesseSchutt\TokenReplacer\Transformers;

use JesseSchutt\TokenReplacer\Contracts\Transformer;
use JesseSchutt\TokenReplacer\Exceptions\InvalidTransformerOptionsException;
use JesseSchutt\TokenReplacer\TokenReplacer;

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
