<?php

namespace App\Http\Wrappers;

/* Exceptions */

use Illuminate\Http\Request;

/* Models */
use App\Http\Models\User;
use Stripe\Stripe;
use Stripe\Product;

class StripeWrapper
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }


    public function generateToken($request)
    {
        $token = $this->stripe->tokens->create(array(
            "card" => array(
                "number"    => '4242424242424242',
                "exp_month" => '12',
                "exp_year"  => '12',
                "cvc"       => '321',
                "name"      => 'name'
            )
        ));


        return $token;
    }

    public function createCustomer($request, User $customer)
    {
        // create customer
        $stripe = $this->stripe->customers->create([
            "email" => \Auth::user()->email,
            "name" => $request->input('name'),
        ]);

        $customer->stripe_customer_id = $stripe->id;
        $customer->save();

        return $customer;
    }


    public function getCustomer($request)
    {
        try {
            $customer = $this->stripe->customers->retrieve(
                'cus_' . \Auth::user()->customer->user_id,
                []
            );
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $this->createCustomer($request);
        }
    }

    public function createCard($request, User $customer)
    {

        $customer = ($customer->stripe_customer_id) ? $customer : self::createCustomer($request, $customer);

        $token =  self::generateToken($request);

        // create source
        $response = $this->stripe->customers->createSource(
            $customer->stripe_customer_id,
            ['source' => $token['id']]
        );


        return $response->toArray(true);
    }

    public function index()
    {
        // Retrieve all products from Stripe
        $products = Product::all();
        return $products;
    }

    public function store($request)
    {
        // Retrieve all products from Stripe
        $products =  Product::create([
            'name' => $request->name,
           'type' => 'service',
        ]);
        dd($products);
        return $products;
    }

    public function subscribe(Request $request, User $user)
    {

        // Create a subscription for the user
        $subscription =  $this->stripe->subscription->create([
            'customer' => $user->stripe_customer_id,
            'items' => [
                ['price' => 'price-id-1'], // Subscription plan 1
            ],
        ]);

        return $subscription->toArray();

        // Redirect or respond with success message
        // ...
    }
}
