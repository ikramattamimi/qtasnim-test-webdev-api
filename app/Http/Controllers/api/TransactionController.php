<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use App\Http\Resources\ApiResource;
use App\Models\Transaction;
use App\Services\ProductService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ApiResource(true, 'List Transaction', Transaction::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTransactionRequest $request, ProductService $productService)
    {
        $transaction = Transaction::create($request->validated());

        // update stock
        $stockChange = $productService->calculateStockChange('store', $request->qty);
        $productService->updateStock($stockChange, $transaction->product);

        return new ApiResource(true, 'Transaction Created', $transaction);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::find($id);
        if ($transaction) {
            return new ApiResource(true, 'Detail Transaction', $transaction);
        }
        return new ApiResource(false, 'Transaction Not Found', []);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateTransactionRequest $request, string $id, ProductService $productService)
    {
        $transaction = Transaction::find($id);
        if ($transaction) {
            $quantityOld = $transaction->qty;

            // update stock
            $stockChange = $productService->calculateStockChange('update', $request->qty, $quantityOld);
            $productService->updateStock($stockChange, $transaction->product);

            $transaction->update($request->validated());
            return new ApiResource(true, 'Transaction Updated', $transaction);
        }
        return new ApiResource(false, 'Transaction Not Found', []);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ProductService $productService)
    {
        $transaction = Transaction::find($id);
        if ($transaction) {

            // update stock
            $stockChange = $productService->calculateStockChange('delete', $transaction->qty);
            $productService->updateStock($stockChange, $transaction->product);

            $transaction->delete();
            return new ApiResource(true, 'Transaction Deleted', $transaction);
        }
        return new ApiResource(false, 'Transaction Not Found', []);
    }
}
