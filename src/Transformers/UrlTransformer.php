<?php

namespace HollyIT\TokenReplace\Transformers;

use HollyIT\TokenReplace\Exceptions\InvalidTransformerOptionsException;
use HollyIT\TokenReplace\TokenReplacer;
use HollyIT\TokenReplace\Contracts\Transformer;

class UrlTransformer implements Transformer
{
    protected string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function process(string $options, TokenReplacer $replacer): string
    {
        if (! $options) {
            throw new InvalidTransformerOptionsException('URL transformer option required');
        }
        $parts = parse_url($this->url);

        return array_key_exists($options, $parts) ? $parts[$options] : '';
    }
}
