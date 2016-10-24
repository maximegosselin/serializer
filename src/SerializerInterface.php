<?php

declare(strict_types=1);

namespace MaximeGosselin\Serializer;

interface SerializerInterface
{
    /**
     * @param $var The variable to be serialized. Must be a supported scalar (boolean, integer, float, string) or and object that implements SerializableInterface
     *
     * @throws SerializationException If the variable cannot be serialized
     *
     * @return array
     */
    public static function serialize($var):array;

    /**
     * @param array $data
     *
     * @throws DeserializationException If the data cannot be deserialized
     *
     * @return mixed
     */
    public static function deserialize(array $data);
}
