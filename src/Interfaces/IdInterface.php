<?php

namespace App\Interfaces;

interface IdInterface{
    public function getId(): int;
    public function setId(int $newId): void;
}