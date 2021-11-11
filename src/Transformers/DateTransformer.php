<?php

namespace HollyIT\TokenReplace\Transformers;

use DateTime;
use HollyIT\TokenReplace\Exceptions\InvalidTransformerOptionsException;
use HollyIT\TokenReplace\TokenReplacer;
use HollyIT\TokenReplace\Contracts\Transformer;

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
