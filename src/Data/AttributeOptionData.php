<?php

namespace JustBetter\AkeneoProducts\Data;

class AttributeOptionData extends Data
{
    public array $rules = [
        'code' => 'required|string',
        'attribute' => 'required|string',
        'sort_order' => 'required|int',
        'labels' => 'array',
    ];

    public function code(): string
    {
        return $this['code'];
    }

    public function attribute(): string
    {
        return $this['attribute'];
    }

    public function sortOrder(): int
    {
        return $this['sort_order'];
    }

    public function labels(): array
    {
        return $this['labels'];
    }
}
