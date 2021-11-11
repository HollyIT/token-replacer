<?php

namespace HollyIT\TokenReplace\Tests;



class TestCase extends \PHPUnit\Framework\TestCase
{
    public function test() {
        \HollyIT\TokenReplace\TokenReplacer::$defaultTransformers = [
            'date' => \HollyIT\TokenReplace\Transformers\DateTransformer::class
        ];
    }
}
