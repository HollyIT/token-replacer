<?php

namespace JesseSchutt\TokenReplacer\Tests\Transformers\Laravel;

use Illuminate\Http\UploadedFile;
use JesseSchutt\TokenReplacer\Facades\TokenReplacer;
use JesseSchutt\TokenReplacer\Tests\TestCase;
use JesseSchutt\TokenReplacer\Transformers\Laravel\UploadedFileTransformer;
use PHPUnit\Framework\Attributes\Test;

class UploadedFileTransformerTest extends TestCase
{
    #[Test]
    public function it_transforms_an_uploaded_file()
    {
        $uploadedFile = UploadedFile::fake()->create('file.pdf', 1000, 'application/pdf');

        $transformer = TokenReplacer::from('You uploaded {{file:basename}} with extension {{file:extension}} and mimetype {{file:mimetype}}')
            ->with('file', new UploadedFileTransformer($uploadedFile));

        $this->assertEquals('You uploaded file.pdf with extension pdf and mimetype application/pdf', $transformer->transform());
    }
}
