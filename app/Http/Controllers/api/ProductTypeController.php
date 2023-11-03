<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductTypeRequest;
use App\Http\Resources\ApiResource;
use App\Models\ProductType;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function compare(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');


        // $query = Transaction::select(
        //     'products.product_type_id',
        //     'product_types.name as product_type_name',

        //     DB::raw('MAX(transactions.qty) as highest_transaction'),
        //     DB::raw('MIN(transactions.qty) as lowest_transaction')
        // )
        //     ->join('products', 'products.id', '=', 'transactions.product_id')
        //     ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
        //     ->groupBy(
        //         'products.product_type_id',
        //         'product_types.name',
        //     );

        $query = Transaction::select(
            'transactions.product_id',
            'products.product_type_id',
            'product_types.name as product_type_name',
            'products.name as product_name',

            DB::raw('MAX(transactions.qty) as highest_transaction'),
            DB::raw('MIN(transactions.qty) as lowest_transaction')
        )
            ->join('products', 'products.id', '=', 'transactions.product_id')
            ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
            ->groupBy(
                'transactions.product_id',
                'products.product_type_id',
                'product_types.name',
                'products.name'
            );

        if ($startDate && $endDate) {
            $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }

        $result = $query->get();

        return new ApiResource(true, 'Compare Result', $result);
    }
}
