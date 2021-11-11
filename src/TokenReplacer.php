<?php

namespace HollyIT\TokenReplace;

use HollyIT\TokenReplace\Contracts\Transformer;

class TokenReplacer
{
    /**
     * Store the global transformers that should be added to every replacer instance.
     * These can be defined by the end user.
     *
     * @var array | Transformer[] | callable[]
     */
    public static array $defaultTransformers = [];

    /**
     * The global default start characters of a token.
     *
     * @var string
     */
    public static string $defaultStartToken = '{{';

    /**
     * The global default end characters of a token.
     *
     * @var string
     */
    public static string $defaultEndToken = '}}';

    /**
     * The start characters of this instance's tokens. Will be
     * static::$defaultStartToken by default
     *
     * @var string
     */
    protected string $startToken;

    /**
     * The close characters of this instance's tokens. Will be
     * static::$defaultEndToken by default
     *
     * @var string
     */
    protected string $endToken;

    /**
     * The default token separator.
     *
     * @var string
     */
    public static string $defaultTokenSeparator = ':';


    /**
     * The character that separates the token from the options.
     *
     * @var string
     */
    protected string $tokenSeparator;

    /**
     * A mapping of the transformers applied to this instance.
     * By default, it will populate with static::$defaultTransformers.
     *
     * @var array|callable[]|Transformer[]
     */
    protected array $transformers;

    /**
     * The string we will be transforming.
     *
     * @var string
     */
    protected string $input;

    /**
     * Should we remove invalid or missing tokens by default?
     *
     * @var bool
     */
    protected bool $removeInvalid = false;

    /**
     * A keyed collection of the formatted strings to replace tokens with.
     *
     * @var array
     */
    protected array $replacements;

    /**
     * A callback that can be applied on each formatter
     * after it has run.
     *
     * @var callable
     */
    protected $replaceCallback;

    /**
     * @param  string  $input
     */
    public function __construct(string $input)
    {
        $this->startToken = static::$defaultStartToken;
        $this->endToken = static::$defaultEndToken;
        $this->transformers = static::$defaultTransformers;
        $this->tokenSeparator = static::$defaultTokenSeparator;
        $this->input = $input;
    }

    /**
     * Simple static constructor for chaining.
     *
     * @param  string  $input
     * @return static
     */
    public static function from(string $input): static
    {
        return new static($input);
    }

    /**
     * Add a new formatter to the instance.
     *
     * @param  string  $tokenName
     * @param  Transformer | callable  $transformer
     * @return $this
     */
    public function with(string $tokenName, mixed $transformer): static
    {
        $this->transformers[$tokenName] = $transformer;

        return $this;
    }

    /**
     * Check if a transformer exists.
     *
     * @param  string  $tokenName
     * @return bool
     */
    public function hasTransformer(string $tokenName): bool
    {
        return isset($this->transformers[$tokenName]);
    }

    /**
     * Remove a transformer if it exists.
     *
     * @param  string  $tokenName
     * @return $this
     */
    public function without(string $tokenName): static
    {
        if ($this->hasTransformer($tokenName)) {
            unset($this->transformers[$tokenName]);
        }

        return $this;
    }

    /**
     * A keyed list of all registered transformers.
     *
     * @return array|callable[]|Transformer[]
     */
    public function transformers(): array
    {
        return $this->transformers;
    }

    /**
     * Add a replacement callback to be fired after each transformer
     * is processed.
     *
     * @param  callable  $callback
     * @return $this
     */
    public function onReplace(callable $callback): static
    {
        $this->replaceCallback = $callback;

        return $this;
    }

    /**
     * If set to true then any token or token-like segment will be
     * removed if the token wasn't found or didn't process.
     *
     * @param  bool  $removeEmptyTokens
     * @return $this
     */
    public function removeEmpty(bool $removeEmptyTokens = true): static
    {
        $this->removeInvalid = $removeEmptyTokens;

        return $this;
    }

    /**
     * The string for the start of a token.
     *
     * @return string
     */
    public function getStartToken(): string
    {
        return $this->startToken;
    }

    /**
     * Set the string for the start of tokens.
     *
     * @param  string  $startToken
     * @return TokenReplacer
     */
    public function startToken(string $startToken): TokenReplacer
    {
        $this->startToken = $startToken;

        return $this;
    }

    /**
     * The string that signifies the end of a token.
     * @return string
     */
    public function getEndToken(): string
    {
        return $this->endToken;
    }

    /**
     * Set the string that signifies the end of a token.
     *
     * @param  string  $endToken
     * @return TokenReplacer
     */
    public function endToken(string $endToken): TokenReplacer
    {
        $this->endToken = $endToken;

        return $this;
    }

    /**
     * If empty or invalid tokens will be removed.
     *
     * @return bool
     */
    public function willRemoveEmpty(): bool
    {
        return $this->removeInvalid;
    }

    /**
     * Generate the regex for our tokens.
     *
     * @param  string  $open
     * @param  string  $close
     * @return string
     */
    public function getPattern(string $open, string $close): string
    {
        $start = preg_quote($open);
        $end = preg_quote($close);

        return $start.'(.*?)'.$end;
    }

    /**
     * Perform the actual transformation of a token.
     *
     * @param  string  $transformer
     * @param $options
     * @return string|null
     */
    public function doTransformation(string $transformer, $options): ?string
    {
        if (isset($this->transformers[$transformer])) {
            if (is_string($this->transformers[$transformer])) {
                $cls = $this->transformers[$transformer];
                $this->transformers[$transformer] = new $cls();
            }

            if ($this->transformers[$transformer] instanceof Transformer) {
                return $this->transformers[$transformer]->process($options, $this);
            } elseif (is_callable($this->transformers[$transformer])) {
                return call_user_func($this->transformers[$transformer], $options, $this);
            }
        }

        return null;
    }

    /**
     * @param $open
     * @param $close
     * @param  callable  $callback
     * @return void
     */
    protected function doTransformations($open, $close, callable $callback)
    {
        if (preg_match_all('#'.$this->getPattern($open, $close).'#x', $this->input, $matches)) {
            foreach ($matches[0] as $key => $search) {
                $token = $matches[1][$key];
                $args = null;
                if (str_contains($matches[1][$key], ':')) {
                    list($token, $args) = explode(':', $matches[1][$key], 2);
                }
                $results = $this->doTransformation(trim($token), trim($args));

                // Let our callback to any alterations if set.
                if (is_callable($this->replaceCallback)) {
                    $results = call_user_func($this->replaceCallback, $results, $token, $args);
                }

                if ($results || $this->removeInvalid) {
                    $this->replacements[$search] = (string) $callback($results);
                }
            }
        }
    }

    /**
     * Actually transform our $input.
     *
     * @return string
     */
    public function transform(): string
    {
        $this->replacements = [];
        $this->doTransformations($this->startToken, $this->endToken, fn ($result) => $result);
        $output = $this->input;

        foreach ($this->replacements as $search => $replace) {
            $output = str_replace($search, $replace, $output);
        }

        return $output;
    }

    /**
     * The input string we will be transforming.
     *
     * @return string
     */
    public function getInput(): string
    {
        return $this->input;
    }

    /**
     * @param  string  $input
     * @return static
     */
    public function setInput(string $input): static
    {
        $this->input = $input;

        return $this;
    }

    /**
     * @return string
     */
    public function getTokenSeparator(): string
    {
        return $this->tokenSeparator;
    }

    /**
     * @param  string  $tokenSeparator
     * @return TokenReplacer
     */
    public function tokenSeparator(string $tokenSeparator): TokenReplacer
    {
        $this->tokenSeparator = $tokenSeparator;

        return $this;
    }

    public function __toString(): string
    {
        return $this->transform();
    }
}
