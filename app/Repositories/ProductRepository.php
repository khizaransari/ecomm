<?php

namespace App\Repositories;

use App\Exceptions\ProductException;
use App\Models\StripeProduct;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function create($data, $request): StripeProduct
    {
        if ($data) {
            $payLoad = ['name' => $request['name'], 'price' => $request['price'], 'stripe_id' => $data['id']];
            return StripeProduct::create($payLoad);
        }

        throw new ProductException('Server Error', 500);
    }

    public function findById($productId): StripeProduct
    {
        $product =  StripeProduct::find($productId);

        if(!$product) {
            throw new ProductException('Product Not Found', 404);
        }

        return $product;
    }

    public function getAll(): Collection
    {
        return StripeProduct::get();
    }

    public function update(StripeProduct $product, $request): StripeProduct
    {
        $update = $product->update(
            [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
            ]
        );

        if(!$update) {
            throw new ProductException('Product Not updated', 404);
        }

        return $product;
    }

    public function delete(StripeProduct $product): void
    {
        $product->delete();
    }

}
