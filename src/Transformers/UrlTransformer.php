<?php

namespace JesseSchutt\TokenReplacer\Transformers;

use JesseSchutt\TokenReplacer\Contracts\Transformer;
use JesseSchutt\TokenReplacer\Exceptions\InvalidTransformerOptionsException;

class UrlTransformer implements Transformer
{
    public function __construct(protected string $url) {}

    /**
     * @throws InvalidTransformerOptionsException
     */
    public function process(string $options): string
    {
        if (! $options) {
            throw new InvalidTransformerOptionsException('URL transformer option required');
        }

        $parts = parse_url($this->url);

        return array_key_exists($options, $parts) ? $parts[$options] : '';
    }
}
