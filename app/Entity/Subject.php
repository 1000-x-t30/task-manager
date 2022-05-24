<?php

namespace App\Entity;

class Subject {

    private ?string $mark = '';
    private ?string $name = '';

    public function setMark(?string $mark): void {
        $this->mark = $mark;
    }
    public function setName(?string $name): void {
        $this->name = $name;
    }

    public function getMark(): ?string {
        return $this->mark;
    }
    public function getName(): ?string {
        return $this->name;
    }
}