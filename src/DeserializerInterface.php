<?php

declare(strict_types = 1);

namespace MaximeGosselin\Serializer;

interface DeserializerInterface
{
    /**
     * @throws DeserializationException If the data cannot be deserialized.
     */
    public function deserialize(array $data);
}
