<?php

namespace JesseSchutt\TokenReplacer;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/token-replacer.php', 'token-replacer');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/token-replacer.php' => config_path('token-replacer.php'),
        ]);
    }
}
