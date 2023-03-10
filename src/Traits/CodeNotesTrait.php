<?php

namespace App\Traits;

trait CodeNotesTrait{
    public function getCode(): string{
        return $this->code;
    }

    public function setCode(string $code): void{
        $this->code = $code;
    }

    public function getNotes(): ?string{
        return $this->notes;
    }

    public function setNotes(string $notes): void{
        $this->notes = $notes;
    }
}