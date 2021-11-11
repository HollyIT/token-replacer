<?php

namespace HollyIT\TokenReplace\Transformers;

use HollyIT\TokenReplace\Exceptions\InvalidTransformerOptionsException;
use HollyIT\TokenReplace\TokenReplacer;
use HollyIT\TokenReplace\Contracts\Transformer;

class FileTransformer implements Transformer
{
    protected string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function process(string $options, TokenReplacer $replacer): string
    {
        if (! $options) {
            throw new InvalidTransformerOptionsException('File transformer option required');
        }

        $parts = pathinfo($this->path);

        return array_key_exists($options, $parts) ? $parts[$options] : '';
    }
}
