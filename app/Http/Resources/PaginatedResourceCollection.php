<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginatedResourceCollection extends ResourceCollection
{
    public static $wrap = 'items';

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }

    public function paginationInformation($request, $paginated, $default)
    {
        return [
            'pagination' => [
                'currentPage' => $paginated['current_page'],
                'total' => $paginated['total'],
                'totalPage' => $paginated['last_page'],
                'path' => $paginated['path'],
            ],
        ];
    }

}
