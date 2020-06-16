<?php

namespace App\Application\Query;

use App\Application\CommandHandlerInterface;

final class GetAllCategoriesCommandHandler implements CommandHandlerInterface
{
    /**
     * @param GetAllCategoriesCommand $query
     */
    public function __invoke(GetAllCategoriesCommand $query)
    {
        dd('here');
    }
}
