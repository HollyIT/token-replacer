<?php

namespace JesseSchutt\TokenReplacer\Tests\Transformers;

use JesseSchutt\TokenReplacer\Facades\TokenReplacer;
use JesseSchutt\TokenReplacer\Tests\TestCase;
use JesseSchutt\TokenReplacer\Transformers\FileTransformer;
use PHPUnit\Framework\Attributes\Test;

class FileTransformerTest extends TestCase
{
    #[Test]
    public function is_extract_from_a_file_path()
    {
        $replacer = TokenReplacer::from('{{ file:basename }} is located in {{ file:dirname }}')
            ->with('file', new FileTransformer('/home/me/test.txt'));

        $this->assertEquals('test.txt is located in /home/me', $replacer);
    }
}
