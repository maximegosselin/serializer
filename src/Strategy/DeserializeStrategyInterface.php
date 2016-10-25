<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Strategy;

use MaximeGosselin\Serializer\DeserializerInterface;

interface DeserializeStrategyInterface extends DeserializerInterface
{
    public function canDeserialize(array $data):bool;
}
