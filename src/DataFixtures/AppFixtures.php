<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->addCategory($manager, 'Soup');
        $pizzaCategory = $this->addCategory($manager, 'Pizza');
        $this->addCategory($manager, 'Drink');

        $pizzaItaliano = new Product();
        $pizzaItaliano->setCategory($pizzaCategory);
        $pizzaItaliano->setTitle('Italiano');
        $pizzaItaliano->setSubTitle('Very nice pizza');
        $pizzaItaliano->setIngredients('tomato and cheese');
        $pizzaItaliano->setPrice(99.99);
        $pizzaItaliano->setWeight(450);
        $pizzaItaliano->setCalories(900);

        $manager->persist($pizzaItaliano);

        $manager->flush();
    }

    private function addCategory(ObjectManager $manager, string $title): ProductCategory
    {
        $category = new ProductCategory();
        $category->setTitle($title);

        $manager->persist($category);

        return $category;
    }
}
