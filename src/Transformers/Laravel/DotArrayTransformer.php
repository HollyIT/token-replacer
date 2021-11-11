<?php

namespace HollyIT\TokenReplace\Transformers\Laravel;

use HollyIT\TokenReplace\Exceptions\InvalidTransformerOptionsException;
use HollyIT\TokenReplace\TokenReplacer;
use HollyIT\TokenReplace\Transformers\Transformer;
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
