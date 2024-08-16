<?php

namespace JesseSchutt\TokenReplacer\Transformers\Laravel;

use JesseSchutt\TokenReplacer\Exceptions\InvalidTransformerOptionsException;
use JesseSchutt\TokenReplacer\TokenReplacer;
use JesseSchutt\TokenReplacer\Transformers\Transformer;
use Illuminate\Support\Arr;

class DotArrayTransformer extends Transformer
{
    protected array $inputArray;

    public function __construct(array $inputArray)
    {
        $this->inputArray = $inputArray;
    }

    public function process(string $options, TokenReplacer $replacer): string
    {
        if (! $options) {
            throw new InvalidTransformerOptionsException('DotArrayTransformer option required');
        }

        return Arr::get($this->inputArray, $options, '');
    }
}
