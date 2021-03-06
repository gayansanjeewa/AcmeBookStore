<?php

namespace App\Controller;

use App\Application\Query\GetAllBooksQuery;
use App\Application\Query\GetAllCategoriesQuery;
use App\ViewModel\Book;
use App\ViewModel\Category;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListAllBooksController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * ListAllBooksController constructor.
     */
    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @Route("/", name="app_book_list")
     */
    public function __invoke(Request $request): Response
    {
        /** @var Category[] $categories */
        $categories = $this->bus->handle(new GetAllCategoriesQuery());

        /** @var Book $books */
        $books = $this->bus->handle(new GetAllBooksQuery($this->filteringCriteria($request)));

//        $request->getSession()->remove('cart'); // TODO@Gayan: remove this code placed for debugging

        $cart = [];
        if ($request->getSession()->has('cart')) {
            $cart = $request->getSession()->get('cart');
        }

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'books'      => $books,
            'quantity'   => !empty($cart['items']) ? count($cart['items']) : 0,
            'total'      => $cart['total'] ?? 0.0,
        ]);
    }

    private function filteringCriteria(Request $request): array
    {
        return [
            'category' => $request->get('category') ?? [],
        ];
    }
}
