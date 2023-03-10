<?php

namespace App\Traits;

trait NameTrait{
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}