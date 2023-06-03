<?php

namespace App\Services;

use App\Models\StripeProduct;
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
        return Product::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
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
