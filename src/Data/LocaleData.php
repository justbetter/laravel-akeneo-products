<?php

namespace JustBetter\AkeneoProducts\Data;

class LocaleData extends Data
{
    public array $rules = [
        'code' => 'required|string',
        'enabled' => 'required|boolean',
    ];

    public function code(): string
    {
        return $this['code'];
    }

    public function enabled(): bool
    {
        return $this['enabled'];
    }
}
