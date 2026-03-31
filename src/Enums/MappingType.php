<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Enums;

enum MappingType: string
{
    case Family = 'family';
    case Category = 'category';
    case Attribute = 'attribute';
}
