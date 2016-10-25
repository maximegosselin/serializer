<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Strategy;

class DoubleSerializeStrategy implements SerializeStrategyInterface
{
    public function serialize($var):array
    {
        if (!$this->canSerialize($var)) {
            throw new InvalidTypeException(gettype($var), 'double');
        }
        return [
            'type' => 'double',
            'payload' => $var
        ];
    }

    public function canSerialize($var):bool
    {
        return is_double($var);
    }
}
