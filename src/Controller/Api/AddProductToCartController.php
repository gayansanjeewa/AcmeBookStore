<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AddProductToCartController extends AbstractController
{
    /**
     * @Route("/api/cart/book", name="api_cart_add_book", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $uuid = $request->get('uuid');

        return new JsonResponse([
            'uuid'     => $uuid,
            'quantity' => 1,
            'total'    => 99,
        ], Response::HTTP_OK);
    }
}
