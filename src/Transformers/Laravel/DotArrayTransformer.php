<?php

namespace JesseSchutt\TokenReplacer\Transformers\Laravel;

use Illuminate\Support\Arr;
use JesseSchutt\TokenReplacer\Contracts\Transformer;
use JesseSchutt\TokenReplacer\Exceptions\InvalidTransformerOptionsException;

class DotArrayTransformer implements Transformer
{
    public function __construct(private readonly array $inputArray) {}

    /**
     * @throws InvalidTransformerOptionsException
     */
    public function process(string $options): string
    {
        if (! $options) {
            throw new InvalidTransformerOptionsException('DotArrayTransformer option required');
        }

        return Arr::get($this->inputArray, $options, '');
    }
}
