<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ShopFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $products = [
            new Product('Chips', 2, 1.21, 'CHIP', 50),
            new Product('Monopoly', 25, 1.21, 'MONOHEL', 20),
            new Product('Magic: the gathering', 5, 1.21, 'MTG', 100),
            new Product('Cookieclicker', 10, 1.21, 'COOKIE', 10)
        ];

        $foodCategory = new Category('Food');
        $foodCategory->addProduct($products[0]);
        $foodCategory->addProduct($products[3]);

        $gameCategory = new Category('Games');
        $gameCategory->addProduct($products[1]);
        $gameCategory->addProduct($products[2]);
        $gameCategory->addProduct($products[3]);

        $categories = [
            $foodCategory,
            $gameCategory
        ];

        foreach($categories AS $category) {
            $manager->persist($category);
        }

        $manager->flush();
    }
}
