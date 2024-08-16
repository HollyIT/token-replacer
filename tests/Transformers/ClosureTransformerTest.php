<?php

namespace JesseSchutt\TokenReplacer\Tests\Transformers;

use JesseSchutt\TokenReplacer\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ClosureTransformerTest extends TestCase
{
    #[Test] public function it_transforms_via_closures()
    {
        $transformer = new \JesseSchutt\TokenReplacer\TokenReplacer('with {{ test1:options }} and without {{ test2 }}');
        $transformer->with('test1', function ($option) {
            return $option;
        })
            ->with('test2', function () {
                return strtoupper('options');
            });


        $this->assertEquals('with options and without OPTIONS', $transformer->transform());
    }
}
