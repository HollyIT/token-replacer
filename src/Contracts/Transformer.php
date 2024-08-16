<?php

namespace JesseSchutt\TokenReplacer\Contracts;

use JesseSchutt\TokenReplacer\TokenReplacer;

interface Transformer
{
    public function process(string $options, TokenReplacer $replacer): string;
}
