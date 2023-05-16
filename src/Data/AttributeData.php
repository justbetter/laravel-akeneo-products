<?php

namespace JustBetter\AkeneoProducts\Data;

class AttributeData extends Data
{
    public array $rules = [
        'code' => 'required|string',
        'type' => 'required|string',
        'unique' => 'required|boolean',
        'localizable' => 'required|boolean',
        'scopable' => 'required|boolean',
    ];

    public function code(): string
    {
        return $this['code'];
    }

    public function type(): string
    {
        return $this['type'];
    }

    public function unique(): bool
    {
        return $this['unique'];
    }

    public function localizable(): bool
    {
        return $this['localizable'];
    }

    public function scopable(): bool
    {
        return $this['scopable'];
    }
}
