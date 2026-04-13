<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Exceptions;

use Exception;

class InvalidValueException extends Exception
{
    public function __construct(string $attribute, mixed $value)
    {
        parent::__construct('The given value "'.var_export($value, true).'" for attribute "'.$attribute.'" is invalid.');
    }
}
