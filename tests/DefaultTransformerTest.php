<?php

namespace JesseSchutt\TokenReplacer\Tests;

use Illuminate\Support\Facades\Config;
use JesseSchutt\TokenReplacer\Facades\TokenReplacer;
use JesseSchutt\TokenReplacer\Transformers\DateTransformer;
use JesseSchutt\TokenReplacer\Transformers\Laravel\DotArrayTransformer;
use PHPUnit\Framework\Attributes\Test;

class DefaultTransformerTest extends TestCase
{
    #[Test]
    public function it_applies_default_transformers()
    {
        Config::set('token-replacer.default_transformers', [
            'date' => DateTransformer::class,
        ]);

        $transformer = TokenReplacer::from('Your name is {{user:name.first}} {{user:name.last}} and today is {{date:Y-m-d}}')
            ->with('user', new DotArrayTransformer([
                'name' => [
                    'first' => 'Jesse',
                    'last' => 'Schutt',
                ],
            ]));

        $this->assertEquals('Your name is Jesse Schutt and today is '.date('Y-m-d'), $transformer);
    }

    #[Test]
    public function it_removes_a_default_transformer()
    {
        Config::set('token-replacer.default_transformers', [
            'date' => DateTransformer::class,
        ]);

        $transformer = TokenReplacer::from('Your name is {{user:name.first}} {{user:name.last}} and today is {{date:Y-m-d}}')
            ->without('date')
            ->with('user', new DotArrayTransformer([
                'name' => [
                    'first' => 'Jesse',
                    'last' => 'Schutt',
                ],
            ]));

        $this->assertEquals('Your name is Jesse Schutt and today is {{date:Y-m-d}}', (string) $transformer);
    }

    #[Test]
    public function it_gets_all_transformers()
    {
        Config::set('token-replacer.default_transformers', [
            'date' => DateTransformer::class,
        ]);

        $transformer = TokenReplacer::from('Your name is {{user:name.first}} {{user:name.last}} and today is {{date:Y-m-d}}');

        $this->assertEquals([
            'date' => DateTransformer::class,
        ], $transformer->transformers());
    }
}
