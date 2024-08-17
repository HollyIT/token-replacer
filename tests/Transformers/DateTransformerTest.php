<?php

namespace JesseSchutt\TokenReplacer\Tests\Transformers;

use JesseSchutt\TokenReplacer\Exceptions\InvalidTransformerOptionsException;
use JesseSchutt\TokenReplacer\Tests\TestCase;
use JesseSchutt\TokenReplacer\TokenReplacer;
use JesseSchutt\TokenReplacer\Transformers\DateTransformer;
use PHPUnit\Framework\Attributes\Test;

class DateTransformerTest extends TestCase
{
    #[Test]
    public function it_transforms_a_date()
    {
        $transformer = new TokenReplacer('replace a {{ date:m }}/{{ date:d }}/{{ date:y }} date token');

        $transformer->with('date', DateTransformer::class);

        $this->assertEquals('replace a '.implode('/', [
            date('m'),
            date('d'),
            date('y'),
        ]).' date token', (string) $transformer);
    }

    #[Test]
    public function it_transforms_a_string_date()
    {
        $transformer = new TokenReplacer('replace a {{ date:m }}/{{ date:d }}/{{ date:y }} date token');

        $transformer->with('date', new DateTransformer('1980/11/04'));

        $this->assertEquals('replace a 11/04/80 date token', (string) $transformer);
    }

    #[Test]
    public function it_requires_a_format_option()
    {
        $transformer = new TokenReplacer('{{ date }}');

        $this->expectException(InvalidTransformerOptionsException::class);

        $transformer->with('date', DateTransformer::class);

        $transformer->transform();
    }
}
