<?php

namespace JesseSchutt\TokenReplacer\Tests\Transformers;

use JesseSchutt\TokenReplacer\Tests\TestCase;
use JesseSchutt\TokenReplacer\TokenReplacer;
use JesseSchutt\TokenReplacer\Transformers\UrlTransformer;
use PHPUnit\Framework\Attributes\Test;

class UrlTransformerTest extends TestCase
{
    #[Test] public function is_extract_from_a_file_path()
    {
        $url = 'https://example.com/index.html';
        $replacer = TokenReplacer::from('{{ url:path }} is located at {{ url:scheme }}://{{ url:host }}')
            ->with('url', new UrlTransformer($url));

        $this->assertEquals('/index.html is located at https://example.com', $replacer->transform());
    }
}
