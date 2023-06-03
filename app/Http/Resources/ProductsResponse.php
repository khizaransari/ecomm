<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResponse;
use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\Collection;

class ProductsResponse extends BaseResponse
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->wrapped([
            'products' => ProductResource::Collection($this)
        ]);
    }
}
