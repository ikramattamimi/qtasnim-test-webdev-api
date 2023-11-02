<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductTypeRequest;
use App\Http\Resources\ApiResource;
use App\Models\ProductType;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ApiResource(true, 'List ProductType', ProductType::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductTypeRequest $request)
    {
        $productType = ProductType::create($request->validated());
        return new ApiResource(true, 'ProductType Created', $productType);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productType = ProductType::find($id);
        if ($productType) {
            return new ApiResource(true, 'Detail ProductType', $productType);
        }
        return new ApiResource(false, 'ProductType Not Found', []);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateProductTypeRequest $request, string $id)
    {
        $productType = ProductType::find($id);
        if ($productType) {
            $productType->update($request->validated());
            return new ApiResource(true, 'ProductType Updated', $productType);
        }
        return new ApiResource(false, 'ProductType Not Found', []);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productType = ProductType::find($id);
        if ($productType) {
            $productType->delete();
            return new ApiResource(true, 'ProductType Deleted', $productType);
        }
        return new ApiResource(false, 'ProductType Not Found', []);
    }
}
