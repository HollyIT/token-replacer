<?php

namespace JesseSchutt\TokenReplacer\Transformers\Laravel;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use JesseSchutt\TokenReplacer\Contracts\Transformer;
use JesseSchutt\TokenReplacer\Exceptions\InvalidTransformerOptionsException;

class ModelTransformer implements Transformer
{
    public function __construct(protected ?Model $model) {}

    /**
     * @throws InvalidTransformerOptionsException
     */
    public function process(string $options): string
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

        if ($value instanceof DateTime) {
            if (isset($options[0])) {
                $value = $value->format($options[0]);
            }
        }

        return (string) $value;
    }
}
