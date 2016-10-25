<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Strategy;

class StringSerializeStrategy implements SerializeStrategyInterface
{
    public function serialize($var):array
    {
        if (!$this->canSerialize($var)) {
            throw new InvalidTypeException(gettype($var), 'string');
        }
        return [
            'type' => 'string',
            'payload' => $var
        ];
    }

    public function canSerialize($var):bool
    {
        return is_string($var);
    }
}
