<?php

namespace JesseSchutt\TokenReplacer;

use JesseSchutt\TokenReplacer\Contracts\Transformer;

class TokenReplacer
{
    /**
     * @var array|callable[]|Transformer[]
     */
    protected array $transformers;

    protected string $input;

    protected bool $removeInvalid = false;

    /**
     * A keyed collection of the formatted strings to replace tokens with.
     *
     * @var array<string, mixed>
     */
    protected array $replacements;

    /**
     * @var callable
     */
    protected $replaceCallback;

    private string $startToken;

    private string $endToken;

    private string $tokenSeparator;

    public function __construct(string $input = '')
    {
        $this->input = $input;
        $this->startToken = config('token-replacer.default_start_token');
        $this->endToken = config('token-replacer.default_end_token');
        $this->tokenSeparator = config('token-replacer.default_token_separator');
        $this->transformers = config('token-replacer.default_transformers', []);
    }

    public function withDelimiters(string $startToken, string $endToken): self
    {
        $this->startToken = $startToken;
        $this->endToken = $endToken;

        return $this;
    }

    public function withTokenSeparator(string $tokenSeparator): self
    {
        $this->tokenSeparator = $tokenSeparator;

        return $this;
    }

    public function from(string $input): static
    {
        return new self($input);
    }

    public function with(string $tokenName, mixed $transformer): static
    {
        $this->transformers[$tokenName] = $transformer;

        return $this;
    }

    public function hasTransformer(string $tokenName): bool
    {
        return isset($this->transformers[$tokenName]);
    }

    public function without(string $tokenName): static
    {
        if ($this->hasTransformer($tokenName)) {
            unset($this->transformers[$tokenName]);
        }

        return $this;
    }

    /**
     * @return array|callable[]|Transformer[]
     */
    public function transformers(): array
    {
        return $this->transformers;
    }

    public function onReplace(callable $callback): static
    {
        $this->replaceCallback = $callback;

        return $this;
    }

    /**
     * If set to true then any token or token-like segment will be
     * removed if the token wasn't found or didn't process.
     */
    public function removeEmpty(bool $removeEmptyTokens = true): static
    {
        $this->removeInvalid = $removeEmptyTokens;

        return $this;
    }

    private function getReplacementPattern(): string
    {
        $start = preg_quote($this->startToken);
        $end = preg_quote($this->endToken);

        return $start.'(.*?)'.$end;
    }

    protected function doTransformations(callable $callback): void
    {
        if (preg_match_all('#'.$this->getReplacementPattern().'#x', $this->input, $matches)) {
            foreach ($matches[0] as $key => $search) {
                $token = $matches[1][$key];
                $args = null;

                if (str_contains($matches[1][$key], $this->tokenSeparator)) {
                    [$token, $args] = explode(
                        $this->tokenSeparator,
                        $matches[1][$key],
                        2
                    );
                }

                $results = $this->doTransformation(trim($token), trim($args ?? ''));

                if (is_callable($this->replaceCallback)) {
                    $results = call_user_func($this->replaceCallback, $results, $token, $args);
                }

                if (($results !== '' && $results !== null && $results !== false) || $this->removeInvalid) {
                    $this->replacements[$search] = (string) $callback($results);
                }
            }
        }
    }

    public function doTransformation(string $transformer, mixed $options): ?string
    {
        if (isset($this->transformers[$transformer])) {
            if (is_string($this->transformers[$transformer])) {
                $class = $this->transformers[$transformer];

                $this->transformers[$transformer] = new $class;
            }

            if ($this->transformers[$transformer] instanceof Transformer) {
                return $this->transformers[$transformer]->process($options);
            } elseif (is_callable($this->transformers[$transformer])) {
                return call_user_func($this->transformers[$transformer], $options, $this);
            }
        }

        return null;
    }

    public function transform(): string
    {
        $this->replacements = [];

        $this->doTransformations(fn ($result) => $result);

        $output = $this->input;

        foreach ($this->replacements as $search => $replace) {
            $output = str_replace($search, $replace, $output);
        }

        return $output;
    }

    public function __toString(): string
    {
        return $this->transform();
    }
}
