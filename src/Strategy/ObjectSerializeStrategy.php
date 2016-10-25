<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Strategy;

use InvalidArgumentException;
use MaximeGosselin\Serializer\SerializableInterface;
use MaximeGosselin\Serializer\SerializerInterface;

class ObjectSerializeStrategy implements SerializeStrategyInterface
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function serialize($var):array
    {
        if (!$this->canSerialize($var)) {
            if (is_scalar($var)) {
                throw new InvalidTypeException(gettype($var), 'object');
            }
            throw new InvalidArgumentException(sprintf(
                'Class %s must implement %s.',
                get_class($var),
                SerializableInterface::class
            ));
        }

        $payload = $var->serialize();
        $serializer = $this->serializer;
        array_walk($payload, function (&$value) use ($serializer) {
            $value = $serializer->serialize($value);
        });

        return [
            'type' => 'object',
            'class' => get_class($var),
            'payload' => $payload
        ];
    }

    public function canSerialize($var):bool
    {
        return ($var instanceof SerializableInterface);
    }
}
