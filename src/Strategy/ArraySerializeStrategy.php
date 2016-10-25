<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Strategy;

use MaximeGosselin\Serializer\SerializerInterface;

class ArraySerializeStrategy implements SerializeStrategyInterface
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
            throw new InvalidTypeException(gettype($var), 'array');
        }

        $payload = [];
        foreach ($var as $key => $value) {
            $payload[$key] = $this->serializer->serialize($value);
        }

        return [
            'type' => 'array',
            'payload' => $payload
        ];
    }

    public function canSerialize($var):bool
    {
        return is_array($var);
    }
}
