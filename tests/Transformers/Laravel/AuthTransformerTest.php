<?php

namespace JesseSchutt\TokenReplacer\Tests\Transformers\Laravel;

use Illuminate\Support\Facades\Auth;
use JesseSchutt\TokenReplacer\Facades\TokenReplacer;
use JesseSchutt\TokenReplacer\Tests\TestCase;
use JesseSchutt\TokenReplacer\Transformers\Laravel\AuthTransformer;
use PHPUnit\Framework\Attributes\Test;
use Workbench\Database\Factories\UserFactory;

class AuthTransformerTest extends TestCase
{
    #[Test]
    public function it_transforms_values_from_an_authenticated_user()
    {
        $user = UserFactory::new()->make([
            'name' => 'Jesse Schutt',
            'email' => 'jesseschutt@gmail.com',
        ]);

        Auth::setUser($user);

        $transformer = TokenReplacer::from('Hello, {{user:name}}! Your email is {{user:email}}.')
            ->with('user', new AuthTransformer);

        $this->assertEquals('Hello, Jesse Schutt! Your email is jesseschutt@gmail.com.', $transformer->transform());
    }
}
