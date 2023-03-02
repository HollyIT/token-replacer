<?php

namespace HollyIT\TokenReplace\Tests\Transformers;

use HollyIT\TokenReplace\Tests\TestCase;
use HollyIT\TokenReplace\TokenReplacer;
use HollyIT\TokenReplace\Transformers\FileTransformer;

class FileTransformerTest extends TestCase
{
    /** @test **/
    public function is_extract_from_a_file_path()
    {
        $path = '/home/me/test.txt';
        $replacer = TokenReplacer::from('{{ file:basename }} is located in {{ file:dirname }}')
            ->with('file', new FileTransformer($path));

        $this->assertEquals('test.txt is located in /home/me', $replacer);
    }
}
