<?php

namespace JesseSchutt\TokenReplacer\Transformers;

use DateTime;
use JesseSchutt\TokenReplacer\Contracts\Transformer;
use JesseSchutt\TokenReplacer\Exceptions\InvalidTransformerOptionsException;
use JesseSchutt\TokenReplacer\TokenReplacer;

class DateTransformer implements Transformer
{
    /**
     * @var DateTime
     */
    protected DateTime $date;

    public function __construct($date = null)
    {
        if (is_string($date)) {
            $date = (new DateTime())->setTimestamp(strtotime($date));
        }

        if (! $date) {
            $date = new DateTime();
        }
        $this->date = $date;
    }

    public function process(string $options, TokenReplacer $replacer): string
    {
        if (! $options) {
            throw new InvalidTransformerOptionsException('Date transformer option required');
        }

        return $this->date->format($options);
    }
}
