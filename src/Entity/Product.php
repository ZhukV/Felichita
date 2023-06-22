<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

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
    #[NotBlank]
    #[Length(max: 100)]
    private string $title;

    #[Column(name: 'sub_title', type: 'string')]
    #[NotBlank]
    #[Length(max: 100)]
    private string $subTitle;

    #[Column(name: 'ingredients', type: 'string', length: 1000)]
    #[NotBlank]
    #[Length(max: 1000)]
    private string $ingredients;

    #[Column(name: 'price', type: 'float', precision: 15, scale: 2)]
    #[NotBlank]
    #[Range(min: 0)]
    private float $price;

    #[Column(name: 'weight', type: 'integer')]
    #[Range(min: 0)]
    private int $weight;

    #[Column(name: 'calories', type: 'integer', nullable: true)]
    #[Range(min: 0)]
    private ?int $calories;

    #[Column(name: 'priority', type: 'integer')]
    private int $priority = 0;

    #[Column(name: 'image_path', type: 'string')]
    #[NotBlank]
    private string $imagePath;

    public function getId(): int
    {
        return $this->id;
    }

    public function setCategory(ProductCategory $category): void
    {
        $this->category = $category;
    }

    public function getCategory(): ProductCategory
    {
        return $this->category;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setSubTitle(string $subTitle): void
    {
        $this->subTitle = $subTitle;
    }

    public function getSubTitle(): string
    {
        return $this->subTitle;
    }

    public function setIngredients(string $ingredients): void
    {
        $this->ingredients = $ingredients;
    }

    public function getIngredients(): string
    {
        return $this->ingredients;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setCalories(?int $calories): void
    {
        $this->calories = $calories;
    }

    public function getCalories(): ?int
    {
        return $this->calories;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    public function setImagePath(string|UploadedFile|null $imagePath): void
    {
        if ($imagePath instanceof UploadedFile) {
            $name = \md5(\uniqid());
            $extension = $imagePath->getClientOriginalExtension();
            $fileName = $name.'.'.$extension;

            $uploadsDir = __DIR__.'/../../public/uploads';

            $imagePath->move($uploadsDir,  $fileName);
            $imagePath = '/uploads/'.$fileName;
        }

        if ($imagePath) {
            $this->imagePath = $imagePath;
        }
    }

    public function getImagePath(): File
    {
        $publicDir = __DIR__.'/../../public';
        $imagePath = $publicDir.$this->imagePath;

        $file = new File($imagePath, false);

        return $file;
    }

    public function getWebImagePath(): string
    {
        return $this->imagePath;
    }
}
