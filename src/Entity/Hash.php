<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\HashRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HashRepository::class)]
#[ApiResource(operations: [
    new Get(),
    new GetCollection(),
    new Post()
])]
class Hash
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $batch = null;

    #[ORM\Column]
    private ?int $blockNumber = null;

    #[ORM\Column(length: 34)]
    private ?string $input = null;

    #[ORM\Column(length: 8)]
    private ?string $key = null;

    #[ORM\Column(length: 34)]
    private ?string $generatedHash = null;

    #[ORM\Column]
    private ?int $numberOfAttempts = null;

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
        return $this->blockNumber;
    }

    public function setBlockNumber(int $blockNumber): self
    {
        $this->blockNumber = $blockNumber;

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
        return $this->generatedHash;
    }

    public function setGeneratedHash(string $generatedHash): self
    {
        $this->generatedHash = $generatedHash;

        return $this;
    }

    public function getnumberOfAttempts(): ?int
    {
        return $this->numberOfAttempts;
    }

    public function setnumberOfAttempts(int $numberOfAttempts): self
    {
        $this->numberOfAttempts = $numberOfAttempts;

        return $this;
    }
}
