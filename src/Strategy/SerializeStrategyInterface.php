<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Strategy;

use MaximeGosselin\Serializer\SerializerInterface;

interface SerializeStrategyInterface extends SerializerInterface
{
    public function canSerialize($var):bool;
}
