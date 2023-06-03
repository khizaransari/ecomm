<?php

namespace App\Services;

use App\Exceptions\StripeException;
use App\Models\StripeProduct;
use Stripe\Exception\ApiErrorException;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }


    public function create($request)
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'default_price' => $request->privce,
        ];
        return Product::create($data);
    }


    public function findById(String $Id)
    {
        return Product::retrieve($Id);
    }

    public function getAll()
    {
        return  Product::all();
    }

    public function update(StripeProduct $product, $request)
    {
        Product::update(
            $product->stripe_id,
            [
                'name' => $request->name,
                'description' => $request->description,
            ]
        );
        return $product;
    }


    public function delete(Product $product): void
    {
        $product->delete();
    }

}
