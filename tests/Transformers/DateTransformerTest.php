<?php

namespace JesseSchutt\TokenReplacer\Tests\Transformers;

use JesseSchutt\TokenReplacer\Exceptions\InvalidTransformerOptionsException;
use JesseSchutt\TokenReplacer\Tests\TestCase;
use JesseSchutt\TokenReplacer\Transformers\DateTransformer;
use PHPUnit\Framework\Attributes\Test;

class DateTransformerTest extends TestCase
{
    #[Test] public function it_transforms_a_date()
    {
        $transformer = new \JesseSchutt\TokenReplacer\TokenReplacer('replace a {{ date:m }}/{{ date:d }}/{{ date:y }} date token');
        $transformer->with('date', DateTransformer::class);
        $this->assertEquals('replace a '. implode('/', [
                date('m'),
                date('d'),
                date('y'),
            ]) . ' date token', (string) $transformer);
    }

    #[Test] public function it_requires_a_format_option()
    {
        $transformer = new \JesseSchutt\TokenReplacer\TokenReplacer('{{ date }}');
        $this->expectException(InvalidTransformerOptionsException::class);
        $transformer->with('date', DateTransformer::class);
        $transformer->transform();
    }
}
