<?php

namespace App\Interfaces;

interface codeNoteInterface{
    public function getCode(): string;
    public function setCode(string $code): void;
    public function getNotes(): ?string;
    public function setNotes(string $notes): void;
}