<?php

namespace App\Controller\Api;

use App\Model\GenerationRequest;
use App\ValueResolver\Attribute\MapJsonGenerationRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api/generate', name: 'app_api_generate_item')]
final class ItemsGeneratorController extends AbstractController {

    #[Route(methods: ['POST'], path: '', name: '_from_yaml', format: 'text')]
    public function generate(
        #[MapJsonGenerationRequest()] GenerationRequest $generationRequest,
    ): JsonResponse {

        dd($generationRequest);
        return $this->json([
            'request' => $generationRequest,
        ]);
    }

}
