<?php

declare(strict_types = 1);

namespace MaximeGosselin\Serializer;

interface SerializableInterface
{
    /**
     * Must return an array of property/value pairs for the properties to serialize.
     *
     * @return array
     */
    public function serialize():array;
}
