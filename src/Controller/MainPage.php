<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductCategory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[AsController]
class MainPage
{
    public function __construct(
        private Environment            $twig,
        private EntityManagerInterface $entityManager
    ) {
    }

    #[Route(
        path: '/',
        name: 'main_page'
    )]
    public function __invoke(): Response
    {
        $categories = $this->entityManager->getRepository(ProductCategory::class)
            ->findBy([], ['priority' => 'ASC']);

        /** @var Product[] $products */
        $products = $this->entityManager->getRepository(Product::class)
            ->findBy([], ['priority' => 'ASC']);

        $groupedProducts = [];

        foreach ($products as $product) {
            $category = $product->getCategory();

            if (!\array_key_exists($category->getId(), $groupedProducts)) {
                $groupedProducts[$category->getId()] = [
                    'priority' => $category->getPriority(),
                    'products' => [],
                ];
            }

            $groupedProducts[$category->getId()]['products'][] = $product;
        }

        \usort($groupedProducts, function (array $a, array $b) {
            if ($a['priority'] === $b['priority']) {
                return 0;
            }

            return $a['priority'] > $b['priority'] ? 1 : -1;
        });

        $content = $this->twig->render('main-page.html.twig', [
            'categories'       => $categories,
            'grouped_products' => $groupedProducts,
        ]);

        return new Response($content);
    }
}
