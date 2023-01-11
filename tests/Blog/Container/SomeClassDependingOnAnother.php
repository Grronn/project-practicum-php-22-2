<?php

namespace Tgu\Savenko\PhpUnit\Blog\Container;

class SomeClassDependingOnAnother
{

    public function __construct(
        SomeClassWithoutDependencies $one,
        SomeClassWithParameter $two
    )
    {

    }
}