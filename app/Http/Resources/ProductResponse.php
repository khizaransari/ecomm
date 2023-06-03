<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResponse;
use App\Http\Resources\ProductResource;

class ProductResponse extends BaseResponse
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
            'product' => (isset($this->id)) ? new ProductResource($this) : (object)[]
        ]);
    }
}
