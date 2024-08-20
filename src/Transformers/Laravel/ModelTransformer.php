<?php

namespace HollyIT\TokenReplace\Transformers\Laravel;

use HollyIT\TokenReplace\Contracts\Transformer;
use HollyIT\TokenReplace\Exceptions\InvalidTransformerOptionsException;
use HollyIT\TokenReplace\TokenReplacer;
use Illuminate\Database\Eloquent\Model;

class ModelTransformer implements Transformer
{
    protected ?Model $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function process(string $options, TokenReplacer $replacer): string
    {
        if (! $this->model) {
            return '';
        }
        if (! $options) {
            throw new InvalidTransformerOptionsException('Model transformers option required.');
        }
        if (str_contains($options, ',')) {
            $options = explode(',', $options);
            $property = $options[0];
            array_shift($options);
        } else {
            $property = $options;
            $options = [];
        }
        $value = $this->model->{$property};
        if ($value instanceof \DateTime) {
            if (isset($options[0])) {
                $value = $value->format($options[0]);
            }
        }

        return (string) $value;
    }
}
