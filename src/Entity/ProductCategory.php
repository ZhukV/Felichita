<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'product_categories')]
class ProductCategory
{
    #[Id]
    #[GeneratedValue(strategy: 'AUTO')]
    #[Column(name: 'id', type: 'integer')]
    private int $id;

    #[Column(name: 'title', type: 'string', length: 100)]
    private string $title;

    #[Column(name: 'priority', type: 'integer')]
    private int $priority;

    public function __construct()
    {
        $this->priority = 0;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }
}
