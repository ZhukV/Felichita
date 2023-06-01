<?php

declare(strict_types = 1);

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[AsController]
class DashboardController
{
    public function __construct(private Environment $twig)
    {
    }

    #[Route(
        path: '/admin',
        name: 'admin_dashboard'
    )]
    public function __invoke(): Response
    {
        $content = $this->twig->render('Admin/dashboard.html.twig');

        return new Response($content);
    }
}
