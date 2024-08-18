<?php

namespace JesseSchutt\TokenReplacer\Tests;

use JesseSchutt\TokenReplacer\Facades\TokenReplacer;
use PHPUnit\Framework\Attributes\Test;

class RemoveEmptyTokenTest extends TestCase
{
    #[Test]
    public function it_removes_empty_tokens()
    {

        $transformer = TokenReplacer::from('Hello, {{name}}!')
            ->removeEmpty()
            ->transform();

        $this->assertEquals('Hello, !', $transformer);
    }
}
