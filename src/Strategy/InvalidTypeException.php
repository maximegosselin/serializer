<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Strategy;

use Exception;
use InvalidArgumentException;

class InvalidTypeException extends InvalidArgumentException
{
    protected $var;

    public function __construct(
        string $actualType,
        string $expectedType,
        $message = "",
        $code = 0,
        Exception $previous = null
    ) {
        $message = sprintf('Invalid type. Got %s, expected %s.', $actualType, $expectedType);
        parent::__construct($message, $code, $previous);
    }
}
