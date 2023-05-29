<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\ProductCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LoadProductCategories extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            'primavera_menu' => 'Primavera Menu',
            'child'          => 'Child menu',
            'pizza'          => 'Pizza',
            'salad'          => 'Salad',
            'snack'          => 'Snack',
            'soup'           => 'Soup',
        ];

        $priority = 0;

        foreach ($categories as $key => $title) {
            $category = new ProductCategory();
            $category->setTitle($title);
            $category->setPriority($priority++);

            $this->setReference($key, $category);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
