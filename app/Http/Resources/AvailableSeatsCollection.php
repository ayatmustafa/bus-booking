<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AvailableSeatsCollection extends ResourceCollection
{

    public function toArray($request)
    {

        return [
            'data' => AvailableSeatsResource::collection($this->collection->toArray()),
            'currentPage' => $this->currentPage(),
            'firstPageUrl' => $this->url(1),
            'from' => $this->firstItem(),
            'lastPage' => $this->lastPage(),
            'lastPageUrl' => $this->url($this->lastPage()),
            'nextPageUrl' => $this->nextPageUrl(),
            'path' => $this->path(),
            'perPage' => $this->perPage(),
            'prevPageUrl' => $this->previousPageUrl(),
            'to' => $this->lastItem(),
            'total' => $this->total(),
        ];
    }
}
