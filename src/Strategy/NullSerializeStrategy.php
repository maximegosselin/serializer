<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Strategy;

class NullSerializeStrategy implements SerializeStrategyInterface
{
    public function serialize($var):array
    {
        if (!$this->canSerialize($var)) {
            throw new InvalidTypeException(gettype($var), 'NULL');
        }
        return [
            'type' => 'null'
        ];
    }

    public function canSerialize($var):bool
    {
        return is_null($var);
    }
}
