<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Range;

#[Entity]
#[Table(name: 'product_categories')]
class ProductCategory
{
    #[Id]
    #[GeneratedValue(strategy: 'AUTO')]
    #[Column(name: 'id', type: 'integer')]
    private int $id;

    #[Column(name: 'title', type: 'string', length: 100)]
    #[Length(min: 2, max: 100)]
    private string $title;

    #[Column(name: 'priority', type: 'integer')]
    #[Range(min: -100, max: +100)]
    private int $priority;

    public function __construct()
    {
        $this->priority = 0;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }
}
