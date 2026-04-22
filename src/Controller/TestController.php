<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/test')]
final class TestController extends AbstractController
{
    #[Route('', name: 'create', methods: ['POST'])]
    public function create(): JsonResponse
    {
        return $this->json(
            [
                'message' => 'Test resource created',
                'status' => 'ok',
            ],
            Response::HTTP_CREATED
        );
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return $this->json(
            [
                'items' => [],
                'status' => 'ok',
            ],
            Response::HTTP_OK
        );
    }

    #[Route('/{id}', name: 'get', methods: ['GET'])]
    public function getOne(
        string $id,
    ): JsonResponse
    {
        return $this->json(
            [
                'id' => $id,
                'status' => 'ok',
            ],
            Response::HTTP_OK
        );
    }
}
