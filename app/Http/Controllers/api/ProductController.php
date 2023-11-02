<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Resources\ApiResource;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ApiResource(true, 'List Product', Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $product = Product::create($request->validated());
        return new ApiResource(true, 'Product Created', $product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            return new ApiResource(true, 'Detail Product', $product);
        }
        return new ApiResource(false, 'Product Not Found', []);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateProductRequest $request, string $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->update($request->validated());
            return new ApiResource(true, 'Product Updated', $product);
        }
        return new ApiResource(false, 'Product Not Found', []);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return new ApiResource(true, 'Product Deleted', $product);
        }
        return new ApiResource(false, 'Product Not Found', []);
    }
}
