<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/fake-item', name: 'app_api_fake_item', format: 'json')]
final class FakeItemController extends AbstractController {

    #[Route(path: '', name: '', methods: ['POST'])]
    public function generate(
        Request $request,
    ): JsonResponse {


        return $this->json([
            'Ahke coucou' => 'COUCOU!!',
        ]);
    }

}
