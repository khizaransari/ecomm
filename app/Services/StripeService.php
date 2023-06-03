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

        try {
            return Product::create($data);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            throw new StripeException($e->getMessage(), $e->getCode());
        }
    }


    public function findById(String $productId)
    {
        try {
            return Product::retrieve($productId);
        } catch (ApiErrorException $e) {
            throw new StripeException($e->getMessage(), $e->getCode());
        }
    }

    public function getAll()
    {
        try {
            return  Product::all();
        } catch (ApiErrorException $e) {
            throw new StripeException($e->getMessage(), $e->getCode());
        }
    }

    public function update(StripeProduct $product, $request)
    {

        try {
            Product::update(
                $product->stripe_id,
                [
                    'name' => $request->name,
                    'description' => $request->description,
                ]
            );

        } catch (ApiErrorException $e) {
            throw new StripeException($e->getMessage(), $e->getCode());
        }

        return $product;
    }


    public function delete(StripeProduct $product)
    {
        $stripeProduct = $this->findById($product->stripe_id);

        try {
            return $stripeProduct->delete();
        } catch (ApiErrorException $e) {
            throw new StripeException($e->getMessage(), $e->getCode());
        }
    }

}
