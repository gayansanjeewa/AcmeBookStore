<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayCartController extends AbstractController
{
    /**
     * @Route("/cart", name="app_display_cart")
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $cart = [];
        if ($request->getSession()->has('cart')) {
            $cart = $request->getSession()->get('cart');
        }

        $uniqueItems = $this->getUniqueItems($cart);

        $bookIdsWithCount = $this->getUniqueBookIds($cart);

        foreach ($uniqueItems as $key => $value) {
            foreach ($bookIdsWithCount as $uuid => $count) {
                if ($value['bookUuid'] === $uuid) {
                    $uniqueItems[$key]['quantity'] = $count;
                }
            }
        }

        $cart['items'] = $uniqueItems;

        return $this->render('cart/index.html.twig', [
            'quantity' => !empty($cart['items']) ? count($cart['items']) : 0,
            'total'    => $cart['total'] ?? 0.0,
            'cart'     => $cart,
        ]);
    }

    private function getUniqueBookIds(array $cart): array
    {
        $bookIds = [];
        foreach ($cart['items'] as $item) {
            $bookIds[] = $item['bookUuid'];
        }
        $bookIdsWithCount = array_count_values($bookIds);

        return $bookIdsWithCount;
    }

    private function getUniqueItems(array $cart): array
    {
        $uniqueArray = [];
        foreach ($cart['items'] as $item) {
            if (in_array($item, $uniqueArray)) {
                continue;
            }
            $uniqueArray[] = $item;
        }

        return $uniqueArray;
    }
}
