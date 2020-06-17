<?php

namespace App\Controller\Api;

use App\Application\Util\Cart;
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
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $cart = $this->applyDiscount($request);

        return new JsonResponse([
            'quantity' => count($cart['items']),
            'total'    => $cart['total'],
        ], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function applyDiscount(Request $request): array
    {
        $cart = $this->getCartFromSession($request->getSession());

        $cart->applyCoupon($request->get('couponCode'));

        $request->getSession()->set('cart', $cart->asArray());

        return $cart->asArray();
    }

    /**
     * @param SessionInterface $session
     * @return Cart
     */
    private function getCartFromSession(SessionInterface $session): Cart
    {
        if ($session->has('cart')) {
            return Cart::create($session->get('cart'));
        }

        return Cart::init();
    }
}
