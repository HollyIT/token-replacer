<?php

namespace JesseSchutt\TokenReplacer\Tests\Transformers\Laravel;

use JesseSchutt\TokenReplacer\Facades\TokenReplacer;
use JesseSchutt\TokenReplacer\Tests\TestCase;
use JesseSchutt\TokenReplacer\Transformers\Laravel\ModelTransformer;
use PHPUnit\Framework\Attributes\Test;
use Workbench\Database\Factories\UserFactory;

class ModelTransformerTest extends TestCase
{
    #[Test]
    public function it_transforms_values_from_an_eloquent_model()
    {
        $user = UserFactory::new()->make([
            'name' => 'Jesse Schutt',
            'email' => 'jesseschutt@gmail.com',
        ]);

        $transformer = TokenReplacer::from('Hello, {{user:name}}! Your email is {{user:email}}.')
            ->with('user', new ModelTransformer($user));

        $this->assertEquals('Hello, Jesse Schutt! Your email is jesseschutt@gmail.com.', $transformer->transform());
    }
}
