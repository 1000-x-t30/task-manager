<?php

namespace App\Entity;

class Task {

    private ?int $id = null;
    private ?string $mark = '';
    private ?string $name = '';
    private ?int $taskNo = null;
    private ?string $description = '';
    private ?string $limit = '';
    private ?string $createdAt = '';
    private ?string $updatedAt = '';


    public function setId(?int $id): void {
        $this->id = $id;
    }
    public function setMark(?string $mark): void {
        $this->mark = $mark;
    }
    public function setName(?string $name): void {
        $this->name = $name;
    }
    public function setTaskNo(?int $taskNo): void {
        $this->taskNo = $taskNo;
    }
    public function setDescription(?string $description): void {
        $this->description = $description;
    }
    public function setLimit(?string $limit): void {
        $this->limit = $limit;
    }
    public function setCreatedAt(?string $createdAt): void {
        $this->createdAt = $createdAt;
    }
    public function setUpdatedAt(?string $updatedAt): void {
        $this->updatedAt = $updatedAt;
    }

    public function getId(): ?int {
        return $this->id;
    }
    public function getMark(): ?string {
        return $this->mark;
    }
    public function getName(): ?string {
        return $this->name;
    }
    public function getTaskNo(): ?int {
        return $this->taskNo;
    }
    public function getDescription(): ?string {
        return $this->description;
    }
    public function getLimit(): ?string {
        return $this->limit;
    }
    public function getCreatedAt(): ?string {
        return $this->createdAt;
    }
    public function getUpdatedAt(): ?string {
        return $this->updatedAt;
    }

}