<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Strategy;

class BooleanSerializeStrategy implements SerializeStrategyInterface
{
    public function serialize($var):array
    {
        if (!$this->canSerialize($var)) {
            throw new InvalidTypeException(gettype($var), 'boolean');
        }
        return [
            'type' => 'boolean',
            'payload' => $var
        ];
    }

    public function canSerialize($var):bool
    {
        return is_bool($var);
    }
}
