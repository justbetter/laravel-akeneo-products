<?php

namespace JustBetter\AkeneoProducts\Data;

class ProductData extends Data
{
    public array $rules = [
        'identifier' => 'required|string',
        'values' => 'nullable|array',
        'family' => 'nullable|string',
        'categories' => 'nullable|array',
    ];

    public function identifier(): string
    {
        return $this['identifier'];
    }

    public function family(): ?string
    {
        return $this['family'];
    }

    public function categories(): ?array
    {
        return $this['categories'];
    }

    public function values(): array
    {
        return $this['values'];
    }
}
