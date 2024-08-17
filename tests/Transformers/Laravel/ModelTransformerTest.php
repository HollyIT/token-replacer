<?php

namespace JesseSchutt\TokenReplacer\Tests\Transformers\Laravel;

use JesseSchutt\TokenReplacer\Exceptions\InvalidTransformerOptionsException;
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

    #[Test]
    public function it_handles_missing_model()
    {
        $transformer = TokenReplacer::from('Hello, {{user:name}}! Your email is {{user:email}}.')
            ->with('user', new ModelTransformer(null));

        $this->assertEquals('Hello, {{user:name}}! Your email is {{user:email}}.', $transformer->transform());
    }

    #[Test]
    public function it_throws_an_exception_if_options_are_not_provided_to_model()
    {
        $user = UserFactory::new()->make([
            'name' => 'Jesse Schutt',
            'email' => 'jesseschutt@gmail.com',
        ]);

        $transformer = TokenReplacer::from('Hello, {{user}}! Your email is {{user}}.')
            ->with('user', new ModelTransformer($user));

        $this->expectException(InvalidTransformerOptionsException::class);

        $transformer->transform();
    }

    #[Test]
    public function it_handles_commas()
    {
        $user = UserFactory::new()->make([
            'name' => 'Jesse Schutt',
            'email' => 'jesseschutt@gmail.com',
            'created_at' => '1985-12-14 00:00:00',
        ]);

        $transformer = TokenReplacer::from('Hello, {{user:name}}! Your birthdate is {{user:created_at,m-d-y}}.')
            ->with('user', new ModelTransformer($user));

        $this->assertEquals('Hello, Jesse Schutt! Your birthdate is 12-14-85.', $transformer->transform());
    }
}
