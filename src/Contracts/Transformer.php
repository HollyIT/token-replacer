<?php

namespace HollyIT\TokenReplace\Contracts;

use HollyIT\TokenReplace\TokenReplacer;

interface Transformer
{
    public function process(string $options, TokenReplacer $replacer): string;
}
