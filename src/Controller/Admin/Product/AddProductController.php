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
class AddProductController
{
    public function __construct(
        private Environment            $twig,
        private EntityManagerInterface $entityManager,
        private FormFactoryInterface   $formFactory,
        private UrlGeneratorInterface  $urlGenerator
    ) {
    }

    #[Route(
        path: '/admin/products/create',
        name: 'admin_product_create'
    )]
    public function __invoke(Request $request): Response
    {
        $form = $this->formFactory->create(ProductType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Product $product */
            $product = $form->getData();

            $imagePath = $form->get('imagePath')->getData();
            $product->setImagePath($imagePath);

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            /** @var Session $session */
            $session = $request->getSession();
            $session->getFlashBag()->add('success', 'Successfully create new product.');

            $redirectUrl = $this->urlGenerator->generate('admin_product_list');

            return new RedirectResponse($redirectUrl);
        }

        $content = $this->twig->render('Admin/Product/product-create.html.twig', [
            'form' => $form->createView(),
        ]);

        return new Response($content);
    }
}
