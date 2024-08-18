<?php

namespace JesseSchutt\TokenReplacer\Tests\Transformers;

use JesseSchutt\TokenReplacer\Facades\TokenReplacer;
use JesseSchutt\TokenReplacer\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ClosureTransformerTest extends TestCase
{
    #[Test]
    public function it_transforms_via_closures()
    {
        $transformer = TokenReplacer::from('with {{ test1:options }} and without {{ test2 }}');

        $transformer->with('test1', fn ($option) => $option)
            ->with('test2', fn () => strtoupper('options'));

        $this->assertEquals('with options and without OPTIONS', $transformer->transform());
    }
}
