<?php

/**
 * This is A
 */

namespace Gomaji\Demo\TestA;

class A
{
    private string $name = 'A';

    public function callMe(): string
    {
        return $this->name;
    }
}
