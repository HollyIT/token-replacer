<?php

namespace JesseSchutt\TokenReplacer\Tests\Transformers;

use JesseSchutt\TokenReplacer\Facades\TokenReplacer;
use JesseSchutt\TokenReplacer\Tests\TestCase;
use JesseSchutt\TokenReplacer\Transformers\ObjectTransformer;
use PHPUnit\Framework\Attributes\Test;

class ObjectTransformerTest extends TestCase
{
    #[Test]
    public function it_extracts_items_from_an_array()
    {
        $obj = new \stdClass;
        $obj->jumper = 'fox';
        $obj->target = 'dog';

        $transformer = TokenReplacer::from('The quick brown {{animal:jumper}} jumped over the lazy {{animal:target}}')
            ->with('animal', new ObjectTransformer($obj));

        $this->assertEquals('The quick brown fox jumped over the lazy dog', $transformer->transform());
    }
}
