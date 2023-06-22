<?php

declare(strict_types = 1);

namespace App\Controller\Admin\Product;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[AsController]
class ListProductsController
{
    public function __construct(
        private Environment            $twig,
        private EntityManagerInterface $entityManager
    ) {
    }

    #[Route(
        path: '/admin/products',
        name: 'admin_product_list'
    )]
    public function __invoke(): Response
    {
        $products = $this->entityManager->getRepository(Product::class)
            ->findBy([], ['priority' => 'ASC']);

        $content = $this->twig->render('Admin/Product/products.html.twig', [
            'products' => $products
        ]);

        return new Response($content);
    }
}