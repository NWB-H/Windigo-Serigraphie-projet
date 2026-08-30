<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginatedResourceArray extends JsonResource
{
    public static $wrap = 'items';

    public function toArray(Request $request): array
    {
        return [
            'items' => $this->resource->items(),

            'pagination' => [
                'currentPage' => $this->resource->currentPage(),
                'total' => $this->resource->total(),
                'totalPage' => $this->resource->lastPage(),
                'path' => $this->resource->path(),
            ],
        ];
    }

    public function paginationInformation($request, $paginated, $default): array
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
