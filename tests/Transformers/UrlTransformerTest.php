<?php

namespace HollyIT\TokenReplace\Tests\Transformers;

use HollyIT\TokenReplace\Tests\TestCase;
use HollyIT\TokenReplace\TokenReplacer;
use HollyIT\TokenReplace\Transformers\UrlTransformer;
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
