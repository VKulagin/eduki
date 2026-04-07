<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreateProductRequest;
use App\Service\ProductManagerInterface;
use App\Service\ProductResponseFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/products')]
final class ProductController extends AbstractController
{
    #[Route('', name: 'product_create', methods: ['POST'])]
    public function create(
        Request $request,
        ValidatorInterface $validator,
        ProductManagerInterface $productManager,
        ProductResponseFactoryInterface $responseFactory,
    ): JsonResponse
    {
        $payload = json_decode($request->getContent(), true) ?? [];
        $productDto = CreateProductRequest::fromArray($payload);

        $errors = $validator->validate($productDto);

        if (count($errors) > 0) {
            return $this->processErrors($errors);
        }

        $product = $productManager->create($productDto);

        return $this->json(
            $responseFactory->one($product),
            Response::HTTP_CREATED
        );
    }

    #[Route('', name: 'product_list', methods: ['GET'])]
    public function list(
        ProductManagerInterface $productManager,
        ProductResponseFactoryInterface $responseFactory,
    ): JsonResponse
    {
        return $this->json(
            $responseFactory->many($productManager->getAll())
        );
    }

    #[Route('/{id}', name: 'product_get', methods: ['GET'])]
    public function getOne(
        string $id,
        ProductManagerInterface $productManager,
        ProductResponseFactoryInterface $responseFactory,
    ): JsonResponse
    {
        $product = $productManager->getById($id);

        if ($product === null) {
            return $this->json(
                ['message' => 'Product not found'],
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->json($responseFactory->one($product));
    }

    private function processErrors($errors): JsonResponse
    {
        $errorMessages = [];

        foreach ($errors as $error) {
            $errorMessages[] = [
                'field' => $error->getPropertyPath(),
                'message' => $error->getMessage(),
            ];
        }

        return $this->json(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
    }
}