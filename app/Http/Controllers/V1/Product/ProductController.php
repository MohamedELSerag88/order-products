<?php

namespace App\Http\Controllers\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ProductRepository;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends Controller
{
    //
    public function __construct(
        protected ProductRepository $productRepository
    ) {
    }

    public function index(){
        return $this->productRepository->all();
    }


    public function store(ProductRequest $request){
        return $this->productRepository->create($request->validated());

    }

    public function update($id, UpdateProductRequest $request){
        return $this->productRepository->update($request->validated(),$id);
    }
}
