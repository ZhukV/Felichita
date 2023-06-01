<?php

declare(strict_types = 1);

namespace App\Controller\Admin\Product;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[AsController]
class ListProductCategoriesController
{
    public function __construct(private Environment $twig)
    {
    }

    #[Route(
        path: '/admin/product-categories',
        name: 'admin_product_category_list'
    )]
    public function __invoke(): Response
    {
        $content = $this->twig->render('Admin/Product/categories.html.twig');

        return new Response($content);
    }
}
