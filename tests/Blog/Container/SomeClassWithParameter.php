<?php

namespace Tgu\Savenko\PhpUnit\Blog\Container;

class SomeClassWithParameter
{
    public function __construct(
        private int $value
    )
    {
    }
    public function getValue():int
    {
        return $this->value;
    }
}