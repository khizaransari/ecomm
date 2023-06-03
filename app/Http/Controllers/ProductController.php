<?php

namespace App\Http\Controllers;

use App\Http\Requests\StripeProductRequest;
use App\Http\Resources\ProductResponse;
use App\Http\Resources\ProductsResponse;
use App\Http\Resources\SuccessResponse;
use App\Repositories\ProductRepository;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $stripeService;
    protected $productRepository;

    public function __construct(StripeService $stripeService, ProductRepository $productRepository)
    {
        $this->stripeService = $stripeService;
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        $products = $this->productRepository->getAll();
        return new ProductsResponse($products);
    }

    public function create(StripeProductRequest $request)
    {
        $stripe = $this->stripeService->create($request);
        $product =  $this->productRepository->create($stripe, $request);
        return new ProductResponse($product);
    }

    public function show($id)
    {
        $product = $this->productRepository->findById($id);
        $this->stripeService->findById($product->stripe_id);
        return new ProductResponse($product);
    }

    public function update(StripeProductRequest $request, $id)
    {
        $product = $this->productRepository->findById($id);
        $this->stripeService->update($product, $request);
        DB::beginTransaction();
        $product = $this->productRepository->update($product, $request);
        DB::commit();
        return new ProductResponse($product);
    }

    public function destroy($id)
    {
        $product = $this->productRepository->findById($id);
        $this->stripeService->findById($product->stripe_id); /// extra check for stripe
        DB::beginTransaction();
        $this->stripeService->delete($product);
        $product = $this->productRepository->delete($product);
        DB::commit();
        // return $product;
        return new SuccessResponse([]);
    }
}
