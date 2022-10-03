<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Doctrine\Odm\Filter\RangeFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\Pagination\Pagination;
use App\Repository\HashRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HashRepository::class)]
#[ApiResource(
    operations: [
    new Get(),
    new GetCollection(),
    new Post(),
    ],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    paginationItemsPerPage: 20
    )
]
#[ApiFilter(RangeFilter::class, properties: ['numberOfAttempts'])]
class Hash
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('write')]
    private ?int $id = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['read', 'write'])]
    private ?\DateTimeInterface $batch = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $blockNumber = null;

    #[ORM\Column(length: 34)]
    #[Groups(['read', 'write'])]
    private ?string $input = null;

    #[ORM\Column(length: 8)]
    #[Groups(['read', 'write'])]
    private ?string $key = null;

    #[ORM\Column(length: 34)]
    #[Groups('write')]
    private ?string $generatedHash = null;

    #[ORM\Column]
    #[Groups('write')]
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
