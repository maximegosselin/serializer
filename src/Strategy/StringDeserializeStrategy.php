<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Strategy;

use InvalidArgumentException;

class StringDeserializeStrategy extends AbstractDeserializeStrategy
{
    public function canDeserialize(array $data):bool
    {
        try {
            $this->assertValidData($data);
        } catch (InvalidArgumentException $e) {
            return false;
        }
        return ($data['type'] == 'string');
    }

    public function deserialize(array $data)
    {
        $this->assertValidData($data);
        return (string)$data['payload'];
    }
}
