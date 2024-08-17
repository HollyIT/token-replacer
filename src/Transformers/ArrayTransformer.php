<?php

namespace JesseSchutt\TokenReplacer\Transformers;

use JesseSchutt\TokenReplacer\Contracts\Transformer;
use JesseSchutt\TokenReplacer\Exceptions\InvalidTransformerOptionsException;

class ArrayTransformer implements Transformer
{
    public function __construct(protected array $inputArray) {}

    /**
     * @throws InvalidTransformerOptionsException
     */
    public function process(string $options): string
    {
        if (! $options) {
            throw new InvalidTransformerOptionsException('ArrayTransformer options required');
        }

        if (array_key_exists($options, $this->inputArray)) {
            return (string) $this->inputArray[$options];
        }

        return '';
    }
}
