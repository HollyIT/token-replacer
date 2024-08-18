<?php

return [
    /**
     *  An array of transformers that will be always available. These transformers do not take input but generate it from the application state.
     */
    'default_transformers' => [
        // 'date' => \JesseSchutt\TokenReplacer\Transformers\DateTransformer::class,
        // 'auth' => \JesseSchutt\TokenReplacer\Transformers\Laravel\AuthTransformer::class,
    ],

    'default_start_token' => '{{',

    'default_end_token' => '}}',

    'default_token_separator' => ':',
];
