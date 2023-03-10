<?php

namespace App\Classes;

use App\Traits\IdTrait;
use App\Traits\CodeNotesTrait;
use App\Traits\NameTrait;
use App\Interfaces\CodeNoteInterface;
use App\Interfaces\NameInterface;
use App\Interfaces\IdInterface;

class Customer implements 
    IdInterface, 
    nameInterface, 
    codeNoteInterface
{
    use idTrait;
    use NameTrait;
    use codeNotesTrait;

    public function __construct(
        private int $id,
        private string $code,
        private string $name,
        private string $notes,
    )
    {
    }

    public function __toString()
    {
        return $this->id;
    }
}