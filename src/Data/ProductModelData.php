<?php

namespace JustBetter\AkeneoProducts\Data;

class ProductModelData extends Data
{
    public array $rules = [
        'code' => 'required|string',
        'values' => 'nullable|array',
        'family' => 'nullable|string',
        'categories' => 'nullable|array',
    ];

    public function code(): string
    {
        return $this['code'];
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
