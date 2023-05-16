<?php

namespace JustBetter\AkeneoProducts\Data;

class ScopeData extends Data
{
    public array $rules = [
        'code' => 'required|string',
        'locales' => 'required|array',
    ];

    public function code(): string
    {
        return $this['code'];
    }

    public function locales(): array
    {
        return $this['locales'];
    }
}
