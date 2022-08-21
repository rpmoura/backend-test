<?php

namespace App\Rules\Transfer;

abstract class Handler
{
    public function __construct(private ?Handler $next = null)
    {
    }

    final public function handle(array $attributes)
    {
        $processed = $this->validate($attributes);

        if ($processed === null && $this->next !== null) {
            $processed = $this->next->handle($attributes);
        }

        return $processed;
    }

    abstract protected function validate(array $attributes);
}
