<?php

declare(strict_types = 1);

namespace MaximeGosselin\Serializer;

interface SerializerInterface
{
    /**
     * @throws SerializationException If the variable cannot be serialized.
     */
    public function serialize($var):array;
}
