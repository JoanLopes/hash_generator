<?php

namespace App\Entity;

use App\Repository\HashRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HashRepository::class)]
class Hash
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $batch = null;

    #[ORM\Column]
    private ?int $block_number = null;

    #[ORM\Column(length: 34)]
    private ?string $input = null;

    #[ORM\Column(length: 8)]
    private ?string $key = null;

    #[ORM\Column(length: 34)]
    private ?string $generated_hash = null;

    #[ORM\Column]
    private ?int $number_of_attempts = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBatch(): ?\DateTimeInterface
    {
        return $this->batch;
    }

    public function setBatch(\DateTimeInterface $batch): self
    {
        $this->batch = $batch;

        return $this;
    }

    public function getBlockNumber(): ?int
    {
        return $this->block_number;
    }

    public function setBlockNumber(int $block_number): self
    {
        $this->block_number = $block_number;

        return $this;
    }

    public function getInput(): ?string
    {
        return $this->input;
    }

    public function setInput(string $input): self
    {
        $this->input = $input;

        return $this;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function getGeneratedHash(): ?string
    {
        return $this->generated_hash;
    }

    public function setGeneratedHash(string $generated_hash): self
    {
        $this->generated_hash = $generated_hash;

        return $this;
    }

    public function getnumberOfAttempts(): ?int
    {
        return $this->number_of_attempts;
    }

    public function setnumberOfAttempts(int $number_of_attempts): self
    {
        $this->number_of_attempts = $number_of_attempts;

        return $this;
    }
}
