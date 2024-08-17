<?php

namespace JesseSchutt\TokenReplacer\Tests;

use JesseSchutt\TokenReplacer\Facades\TokenReplacer;
use PHPUnit\Framework\Attributes\Test;

class OnReplaceCallbackTest extends TestCase
{
    #[Test]
    public function it_runs_the_on_replace_callback_after_transforming()
    {
        $transformer = TokenReplacer::from('Hello, {{name}}')
            ->with('name', fn ($value) => 'Jesse')
            ->onReplace(function ($value) {
                return strtoupper($value).'!';
            });

        $this->assertEquals('Hello, JESSE!', $transformer->transform());
    }
}
