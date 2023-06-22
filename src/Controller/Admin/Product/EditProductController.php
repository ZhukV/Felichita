<?php

declare(strict_types = 1);

namespace App\Controller\Admin\Product;

use App\Entity\Product;
use App\Form\Type\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

#[AsController]
class EditProductController
{
    public function __construct(
        private Environment            $twig,
        private EntityManagerInterface $entityManager,
        private FormFactoryInterface   $formFactory,
        private UrlGeneratorInterface  $urlGenerator
    ) {
    }

    #[Route(
        path: '/admin/products/{productId}/edit',
        name: 'admin_product_edit'
    )]
    public function __invoke(Request $request, int $productId): Response
    {
        $product = $this->entityManager->find(Product::class, $productId);

        $form = $this->formFactory->create(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagePath = $form->get('imagePath')->getData();

            $product->setImagePath($imagePath);

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            $redirectUrl = $this->urlGenerator->generate('admin_product_list');

            /** @var Session $session */
            $session = $request->getSession();
            $session->getFlashBag()->add('success', 'Successfully edited product.');

            return new RedirectResponse($redirectUrl);
        }

        $content = $this->twig->render('Admin/Product/product-edit.html.twig', [
            'form' => $form->createView(),
        ]);

        return new Response($content);
    }
}