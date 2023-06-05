<?php

declare(strict_types = 1);

namespace App\Controller\Admin\Product;

use App\Entity\ProductCategory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsController]
class RemoveProductCategoryController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UrlGeneratorInterface  $urlGenerator
    ) {
    }

    #[Route(
        path: '/admin/product-categories/{categoryId}/remove',
        name: 'admin_product_category_remove',
        requirements: ['categoryId' => '\d+']
    )]
    public function __invoke(Request $request, int $categoryId): RedirectResponse
    {
        $category = $this->entityManager->getRepository(ProductCategory::class)
            ->find($categoryId);

        $this->entityManager->remove($category);
        $this->entityManager->flush();

        /** @var Session $session */
        $session = $request->getSession();
        $session->getFlashBag()->add('success', 'Successfully removed product category.');

        $redirectUrl = $this->urlGenerator->generate('admin_product_category_list');

        return new RedirectResponse($redirectUrl);
    }
}
