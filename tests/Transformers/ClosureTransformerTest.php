<?php

namespace HollyIT\TokenReplace\Tests\Transformers;

use HollyIT\TokenReplace\Tests\TestCase;

class ClosureTransformerTest extends TestCase
{
    /** @test * */
    public function it_transforms_via_closures()
    {
        $transformer = new \HollyIT\TokenReplace\TokenReplacer('with {{ test1:options }} and without {{ test2 }}');
        $transformer->with('test1', function ($option) {
            return $option;
        })
            ->with('test2', function () {
                return strtoupper('options');
            });


        $this->assertEquals('with options and without OPTIONS', $transformer->transform());
    }
}
