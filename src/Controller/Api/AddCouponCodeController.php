<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

final class AddCouponCodeController extends AbstractController
{
    /**
     * @Route("/api/cart/coupon", name="api_cart_add_coupon", methods={"POST"})
     */
    public function __invoke(Request $request): JsonResponse
    {
        $cart = $this->applyCouponCode($request, $this->getCartFromSession($request->getSession()),
            $request->get('couponCode'));

        return new JsonResponse([
            'quantity' => count($cart['items']),
            'total'    => $cart['total'],
        ], Response::HTTP_OK);
    }

    private function getCartFromSession(SessionInterface $session): array
    {
        if ($session->has('cart')) {
            return $session->get('cart');
        }

        $session->set('cart', ['items' => [], 'total' => 0]);

        return $session->get('cart');
    }

    private function applyCouponCode(Request $request, array $cart, string $couponCode)
    {
        // TODO@Gayan: Add validation for $couponCode

        if (empty($couponCode)) {
            return $this->addNewCartToSession($request, $cart);
        }

        if (!empty($cart['couponDiscount'])) {
            return $this->addNewCartToSession($request, $cart);
        }

        if (!empty($cart['childrenCategoryDiscount'])) {
            $cart['total'] += $cart['childrenCategoryDiscount'];
        }

        if (!empty($cart['totalCategoryDiscount'])) {
            $cart['total'] += $cart['totalCategoryDiscount'];
        }

        $cart['couponDiscount'] = $cart['total'] * .15;
        $cart['total'] -= $cart['couponDiscount'];

        return $this->addNewCartToSession($request, $cart);
    }

    private function addNewCartToSession(Request $request, array $cart): array
    {
        $request->getSession()->set('cart', $cart);

        return $cart;
    }
}
