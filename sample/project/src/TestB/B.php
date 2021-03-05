<?php

/**
* This is B
*/

namespace Gomaji\Demo\TestB;

class B
{
    private string $name = 'B';

    public function showMe(): string
    {
        return $this->name;
    }
}
