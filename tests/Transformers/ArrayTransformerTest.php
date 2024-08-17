<?php

namespace JesseSchutt\TokenReplacer\Tests\Transformers;

use JesseSchutt\TokenReplacer\Facades\TokenReplacer;
use JesseSchutt\TokenReplacer\Tests\TestCase;
use JesseSchutt\TokenReplacer\Transformers\ArrayTransformer;
use PHPUnit\Framework\Attributes\Test;

class ArrayTransformerTest extends TestCase
{
    #[Test]
    public function it_extracts_items_from_an_array()
    {
        $transformer = TokenReplacer::from('The quick brown {{animal:jumper}} jumped over the lazy {{animal:target}}')
            ->with('animal', new ArrayTransformer([
                'jumper' => 'fox',
                'target' => 'dog',
            ]));

        $this->assertEquals('The quick brown fox jumped over the lazy dog', $transformer->transform());
    }

    #[Test]
    public function it_removes_missing_array_values()
    {
        $transformer = TokenReplacer::from('The quick brown {{animal:jumper}} jumped over the lazy {{animal:target}}')
            ->with('animal', new ArrayTransformer([
                'jumper' => 'fox',
            ]))->removeEmpty(true);

        $this->assertEquals('The quick brown fox jumped over the lazy ', $transformer->transform());
    }

    #[Test]
    public function it_allows_a_string_of_0_to_pass()
    {
        $transformer = TokenReplacer::from('My bank account balance sits at {{account:balance}}')
            ->with('account', new ArrayTransformer([
                'balance' => '0',
            ]));

        $this->assertEquals('My bank account balance sits at 0', $transformer->transform());
    }
}
