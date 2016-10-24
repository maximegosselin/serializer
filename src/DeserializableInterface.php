<?php

declare(strict_types=1);

namespace MaximeGosselin\Serializer;

interface DeserializableInterface
{
    /**
     * @param array $data
     *
     * @throws DeserializationException If the data cannot be deserialized
     *
     * @return mixed
     */
    public static function deserialize(array $data);
}
