<?php

namespace JesseSchutt\TokenReplacer\Transformers\Laravel;

use Illuminate\Http\UploadedFile;
use JesseSchutt\TokenReplacer\Contracts\Transformer;
use JesseSchutt\TokenReplacer\Exceptions\InvalidTransformerOptionsException;

class UploadedFileTransformer implements Transformer
{
    public function __construct(protected UploadedFile $uploadedFile) {}

    /**
     * @throws InvalidTransformerOptionsException
     */
    public function process(string $options): string
    {
        if (! $options) {
            throw new InvalidTransformerOptionsException('Upload transformer option required.');
        }

        return match ($options) {
            'basename' => (string) pathinfo($this->uploadedFile->getClientOriginalName(), PATHINFO_BASENAME),
            'extension' => (string) $this->uploadedFile->guessClientExtension(),
            'mimetype' => (string) $this->uploadedFile->getMimeType(),
            default => '',
        };
    }
}
