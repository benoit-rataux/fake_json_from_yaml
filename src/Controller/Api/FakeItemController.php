<?php

namespace App\Controller\Api;

use App\Model\UserQuerry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/fake-item', name: 'app_api_fake_item')]
final class FakeItemController extends AbstractController {

    #[Route(path: '', name: '', methods: ['POST'], format: 'json')]
    public function generate(
        #[MapRequestPayload()] UserQuerry $itemRequest,
    ): JsonResponse {


        return $this->json([
            'Ahke coucou' => 'COUCOU!!',
            'request'     => $itemRequest,
        ]);
    }

}
