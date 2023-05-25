<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'products')]
class Product
{
    #[Id]
    #[GeneratedValue(strategy: 'AUTO')]
    #[Column(name: 'id', type: 'integer')]
    private int $id;

    #[ManyToOne(targetEntity: ProductCategory::class)]
    #[JoinColumn(name: 'category_id', referencedColumnName: 'id', nullable: false, onDelete: 'RESTRICT')]
    private ProductCategory $category;

    #[Column(name: 'title', type: 'string')]
    private string $title;

    #[Column(name: 'sub_title', type: 'string')]
    private string $subTitle;

    #[Column(name: 'ingredients', type: 'string', length: 1000)]
    private string $ingredients;

    #[Column(name: 'price', type: 'float', precision: 15, scale: 2)]
    private float $price;

    #[Column(name: 'weight', type: 'integer')]
    private int $weight;

    #[Column(name: 'calories', type: 'integer')]
    private int $calories;

    public function setCategory(ProductCategory $category): void
    {
        $this->category = $category;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setSubTitle(string $subTitle): void
    {
        $this->subTitle = $subTitle;
    }

    public function setIngredients(string $ingredients): void
    {
        $this->ingredients = $ingredients;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    public function setCalories(int $calories): void
    {
        $this->calories = $calories;
    }
}
