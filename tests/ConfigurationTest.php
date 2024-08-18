<?php

namespace JesseSchutt\TokenReplacer\Tests;

use JesseSchutt\TokenReplacer\Facades\TokenReplacer;
use PHPUnit\Framework\Attributes\Test;

class ConfigurationTest extends TestCase
{
    #[Test]
    public function it_overrides_token_delimiters()
    {
        $replacer = TokenReplacer::from('%% token:args %%')
            ->withDelimiters('%%', '%%')
            ->with('token', fn ($args) => strtoupper($args));

        $this->assertEquals('ARGS', $replacer->transform());
    }

    #[Test]
    public function it_overrides_token_separators()
    {
        $replacer = TokenReplacer::from('{{ token%args }}')
            ->withTokenSeparator('%')
            ->with('token', fn ($args) => strtoupper($args));

        $this->assertEquals('ARGS', $replacer->transform());
    }
}
