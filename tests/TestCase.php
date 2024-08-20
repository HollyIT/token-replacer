<?php

namespace HollyIT\TokenReplace\Tests;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        \HollyIT\TokenReplace\TokenReplacer::$defaultTransformers = [
            'date' => \HollyIT\TokenReplace\Transformers\DateTransformer::class,
        ];
    }
}
