<?php

declare(strict_types = 1);

namespace MaximeGosselin\Serializer;

use MaximeGosselin\Serializer\Strategy\ArrayDeserializeStrategy;
use MaximeGosselin\Serializer\Strategy\ArraySerializeStrategy;
use MaximeGosselin\Serializer\Strategy\BooleanDeserializeStrategy;
use MaximeGosselin\Serializer\Strategy\BooleanSerializeStrategy;
use MaximeGosselin\Serializer\Strategy\DeserializeStrategyInterface;
use MaximeGosselin\Serializer\Strategy\DoubleDeserializeStrategy;
use MaximeGosselin\Serializer\Strategy\DoubleSerializeStrategy;
use MaximeGosselin\Serializer\Strategy\IntegerDeserializeStrategy;
use MaximeGosselin\Serializer\Strategy\IntegerSerializeStrategy;
use MaximeGosselin\Serializer\Strategy\NullDeserializeStrategy;
use MaximeGosselin\Serializer\Strategy\NullSerializeStrategy;
use MaximeGosselin\Serializer\Strategy\ObjectDeserializeStrategy;
use MaximeGosselin\Serializer\Strategy\ObjectSerializeStrategy;
use MaximeGosselin\Serializer\Strategy\SerializeStrategyInterface;
use MaximeGosselin\Serializer\Strategy\StringDeserializeStrategy;
use MaximeGosselin\Serializer\Strategy\StringSerializeStrategy;

class Engine implements SerializerInterface, DeserializerInterface
{
    /**
     * @var array
     */
    protected $serializeStrategies;

    /**
     * @var array
     */
    protected $deserializeStrategies;

    public function __construct()
    {
        $this->serializeStrategies = [
            new BooleanSerializeStrategy(),
            new DoubleSerializeStrategy(),
            new IntegerSerializeStrategy(),
            new StringSerializeStrategy(),
            new NullSerializeStrategy(),
            new ArraySerializeStrategy($this),
            new ObjectSerializeStrategy($this),
        ];

        $this->deserializeStrategies = [
            new BooleanDeserializeStrategy(),
            new DoubleDeserializeStrategy(),
            new IntegerDeserializeStrategy(),
            new StringDeserializeStrategy(),
            new NullDeserializeStrategy(),
            new ArrayDeserializeStrategy($this),
            new ObjectDeserializeStrategy($this)
        ];
    }

    public function serialize($var):array
    {
        /** @var SerializeStrategyInterface $strategy */
        foreach ($this->serializeStrategies as $strategy) {
            if ($strategy->canSerialize($var)) {
                return $strategy->serialize($var);
            }
        }

        $message = <<<EOT
Invalid variable of type %s. To be serialized, variable must be a scalar, an array, NULL, or object implementing %s.
EOT;
        throw new SerializationException(sprintf(
            $message,
            gettype($var),
            SerializableInterface::class
        ));
    }

    public function deserialize(array $data)
    {
        /** @var DeserializeStrategyInterface $strategy */
        foreach ($this->deserializeStrategies as $strategy) {
            if ($strategy->canDeserialize($data)) {
                return $strategy->deserialize($data);
            }
        }

        throw new DeserializationException('Could not deserialize data.');
    }
}
