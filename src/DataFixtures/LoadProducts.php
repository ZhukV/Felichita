<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LoadProducts extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            LoadProductCategories::class,
        ];
    }

    public function load(ObjectManager $manager)
    {
        $products = [
            [
                'category'    => 'child',
                'title'       => 'Burger',
                'sub_title'   => 'Child burger',
                'ingredients' => 'bread, cheese, sous, tomato, potato',
                'price'       => 198.0,
                'weight'      => 330,
                'calories'    => 280,
                'image'       => '/fixtures/burger.png',
            ],

            [
                'category'    => 'child',
                'title'       => 'Potato fries',
                'sub_title'   => '',
                'ingredients' => 'potato, sous, salt',
                'price'       => 56.0,
                'weight'      => 100,
                'calories'    => null,
                'image'       => '/fixtures/potato.png',
            ],

            [
                'category'    => 'soup',
                'title'       => 'Borsch',
                'sub_title'   => 'Ukrainian Borsch',
                'ingredients' => 'russian orks ;)',
                'price'       => 0,
                'weight'      => 700,
                'calories'    => 20,
                'image'       => '/fixtures/borsch.png',
            ],
        ];

        foreach ($products as $item) {
            $product = new Product();

            $category = $this->getReference($item['category']);

            $product->setCategory($category);
            $product->setTitle($item['title']);
            $product->setSubTitle($item['sub_title']);
            $product->setIngredients($item['ingredients']);
            $product->setPrice($item['price']);
            $product->setWeight($item['weight']);
            $product->setCalories($item['calories']);
            $product->setImagePath($item['image']);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
