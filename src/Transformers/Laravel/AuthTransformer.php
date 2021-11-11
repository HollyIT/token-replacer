<?php

namespace HollyIT\TokenReplace\Transformers\Laravel;

class AuthTransformer extends ModelTransformer
{
    public function __construct()
    {
        parent::__construct(auth()->user());
    }
}
