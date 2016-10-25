<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Strategy;

use InvalidArgumentException;
use MaximeGosselin\Serializer\DeserializableInterface;
use MaximeGosselin\Serializer\DeserializerInterface;

class ObjectDeserializeStrategy extends AbstractDeserializeStrategy
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
        return ($data['type'] == 'object');
    }

    public function deserialize(array $data)
    {
        $this->assertValidData($data);

        $class = $data['class'];
        $payload = $data['payload'];

        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf('Class %s not found.', $class));
        }

        if (!in_array(DeserializableInterface::class, class_implements($class))) {
            throw new InvalidArgumentException(sprintf(
                'Class %s must implement %s.',
                $class,
                DeserializableInterface::class
            ));
        }

        array_walk($payload, function (&$value) {
            $value = $this->deserializer->deserialize($value);
        });

        return forward_static_call([$class, 'deserialize'], $payload);
    }
}
