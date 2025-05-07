<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/template', name: 'app_item_template')]
final class ItemTemplateController extends AbstractController {

    #[Route('/', name: '')]
    public function index(): Response {
        return $this->render('item_template/index.html.twig', [
            'controller_name' => 'ItemTemplateController',
        ]);
    }

}
