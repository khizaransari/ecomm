<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Wrappers\StripeWrapper;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function store(Request $request)
    {
        $stripe =  new StripeWrapper();
        $response = $stripe->store($request);
        return $response->all();
    }

    public function index(Request $request)
    {
        $stripe =  new StripeWrapper();
        $response = $stripe->index();
        return $response->all();
    }

    public function update(Request $request)
    {
        $stripe =  new StripeWrapper();
        $response = $stripe->index();
        return $response->all();
    }

    //
}
