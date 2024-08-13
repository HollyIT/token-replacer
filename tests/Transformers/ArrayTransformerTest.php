<?php

namespace HollyIT\TokenReplace\Tests\Transformers;

use HollyIT\TokenReplace\Tests\TestCase;
use HollyIT\TokenReplace\TokenReplacer;
use HollyIT\TokenReplace\Transformers\ArrayTransformer;
use PHPUnit\Framework\Attributes\Test;

class ArrayTransformerTest extends TestCase
{
    #[Test] public function it_extracts_items_from_an_array()
    {
        $str = 'The quick brown {{animal:jumper}} jumped over the lazy {{animal:target}}';
        $transformer = TokenReplacer::from($str)
            ->with('animal', new ArrayTransformer([
                'jumper' => 'fox',
                'target' => 'dog',
            ]));

        $this->assertEquals('The quick brown fox jumped over the lazy dog', $transformer->transform());
    }

    #[Test] public function it_removes_missing_array_values()
    {
        $str = 'The quick brown {{animal:jumper}} jumped over the lazy {{animal:target}}';
        $transformer = TokenReplacer::from($str)
            ->with('animal', new ArrayTransformer([
                'jumper' => 'fox',
            ]))->removeEmpty(true);


        $this->assertEquals('The quick brown fox jumped over the lazy ', $transformer->transform());
    }

    #[Test] public function it_allows_a_string_of_0_to_pass()
    {
        $str = 'My bank account balance sits at {{account:balance}}';
        $transformer = TokenReplacer::from($str)
            ->with('account', new ArrayTransformer([
                'balance' => '0',
            ]));


        $this->assertEquals('My bank account balance sits at 0', $transformer->transform());
    }
}
