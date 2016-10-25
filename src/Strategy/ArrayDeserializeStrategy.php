<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Strategy;

use InvalidArgumentException;
use MaximeGosselin\Serializer\DeserializerInterface;

class ArrayDeserializeStrategy extends AbstractDeserializeStrategy
{

    /**
     * @var DeserializerInterface
     */
    protected $deserializer;

    public function __construct(DeserializerInterface $deserializer)
    {
        $this->deserializer = $deserializer;
    }

    public function canDeserialize(array $data):bool
    {
        try {
            $this->assertValidData($data);
        } catch (InvalidArgumentException $e) {
            return false;
        }
        return ($data['type'] == 'array');
    }

    public function deserialize(array $data)
    {
        $this->assertValidData($data);

        $payload = $data['payload'];
        $deserializer = $this->deserializer;
        array_walk($payload, function (&$value) use ($deserializer) {
            $value = $deserializer->deserialize($value);
        });

        return $payload;
    }
}
