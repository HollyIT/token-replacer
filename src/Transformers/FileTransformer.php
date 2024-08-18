<?php

namespace JesseSchutt\TokenReplacer\Transformers;

use JesseSchutt\TokenReplacer\Contracts\Transformer;
use JesseSchutt\TokenReplacer\Exceptions\InvalidTransformerOptionsException;

class FileTransformer implements Transformer
{
    public function __construct(protected string $path) {}

    /**
     * @throws InvalidTransformerOptionsException
     */
    public function process(string $options): string
    {
        if (! $options) {
            throw new InvalidTransformerOptionsException('File transformer option required');
        }

        $parts = pathinfo($this->path);

        $parts['dirname'] = $parts['dirname'] === '.' ? '' : $parts['dirname'];

        return array_key_exists($options, $parts) ? $parts[$options] : '';
    }
}
