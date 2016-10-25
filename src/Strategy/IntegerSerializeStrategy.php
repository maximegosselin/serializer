<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Strategy;

class IntegerSerializeStrategy implements SerializeStrategyInterface
{
    public function serialize($var):array
    {
        if (!$this->canSerialize($var)) {
            throw new InvalidTypeException(gettype($var), 'integer');
        }
        return [
            'type' => 'integer',
            'payload' => $var
        ];
    }

    public function canSerialize($var):bool
    {
        return is_int($var);
    }
}
