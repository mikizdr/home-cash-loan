<?php

namespace App\Helper;

use Illuminate\Pagination\LengthAwarePaginator;

class CustomPaginator
{
    /**
     * Paginate the given array.
     *
     * @param array $array
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public static function paginate(array $array, int $perPage = 10): LengthAwarePaginator
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($array, ($currentPage - 1) * $perPage, $perPage);
        $paginatedItems = new LengthAwarePaginator($currentItems, count($array), $perPage);
        $paginatedItems->setPath(request()->url());

        return $paginatedItems;
    }
}
