<?php

namespace App\Classes;

use App\Traits\CodeNotesTrait;
use App\Traits\IdTrait;
use App\Traits\NameTrait;
use App\Interfaces\CodeNoteInterface;
use App\Interfaces\NameInterface;
use App\Interfaces\IdInterface;

class Host implements 
    IdInterface, 
    nameInterface, 
    codeNoteInterface
{
    use IdTrait;
    use NameTrait;
    use CodeNotesTrait;

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