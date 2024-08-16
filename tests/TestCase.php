<?php

namespace JesseSchutt\TokenReplacer\Tests;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        \JesseSchutt\TokenReplacer\TokenReplacer::$defaultTransformers = [
            'date' => \JesseSchutt\TokenReplacer\Transformers\DateTransformer::class,
        ];
    }
}
