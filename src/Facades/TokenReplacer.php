<?php

namespace JesseSchutt\TokenReplacer\Facades;

use Illuminate\Support\Facades\Facade;

class TokenReplacer extends Facade
{
    /**
     * @method static \JesseSchutt\TokenReplacer\TokenReplacer from(string $input)
     * @method static \JesseSchutt\TokenReplacer\TokenReplacer withDelimiters(string $startToken, string $endToken)
     * @method static \JesseSchutt\TokenReplacer\TokenReplacer withTokenSeparator(string $tokenSeparator)
     * @method static \JesseSchutt\TokenReplacer\TokenReplacer with(string $name, array|callable[]|\JesseSchutt\TokenReplacer\Contracts\Transformer[] $transformers)
     * @method static bool hasTransformer(string $tokenName)
     * @method static \JesseSchutt\TokenReplacer\TokenReplacer without(string $tokenName)
     * @method static array|callable[]|\JesseSchutt\TokenReplacer\Contracts\Transformer[] transformers()
     * @method static \JesseSchutt\TokenReplacer\TokenReplacer onReplace(callable $callback)
     * @method static \JesseSchutt\TokenReplacer\TokenReplacer removeEmpty(bool $removeEmptyTokens = true)
     * @method static string|null doTransformation(string $transformer, mixed $options)
     * @method static string transform()
     * @method static string __toString()
     *
     * @see \JesseSchutt\TokenReplacer\TokenReplacer
     */
    protected static function getFacadeAccessor(): string
    {
        return \JesseSchutt\TokenReplacer\TokenReplacer::class;
    }
}
