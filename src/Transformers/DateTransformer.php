<?php

namespace JesseSchutt\TokenReplacer\Transformers;

use DateTime;
use JesseSchutt\TokenReplacer\Contracts\Transformer;
use JesseSchutt\TokenReplacer\Exceptions\InvalidTransformerOptionsException;

class DateTransformer implements Transformer
{
    public function __construct(protected null|string|DateTime $date = null)
    {
        if (is_string($date)) {
            $date = (new DateTime)->setTimestamp(strtotime($date));
        }

        if (! $date) {
            $date = new DateTime;
        }

        $this->date = $date;
    }

    /**
     * @throws InvalidTransformerOptionsException
     */
    public function process(string $options): string
    {
        if (! $options) {
            throw new InvalidTransformerOptionsException('Date transformer option required');
        }

        return $this->date->format($options);
    }
}
