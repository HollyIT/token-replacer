<?php

namespace JesseSchutt\TokenReplacer\Contracts;

interface Transformer
{
    public function process(string $options): string;
}
