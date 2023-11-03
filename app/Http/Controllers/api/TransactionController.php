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
        return new ApiResource(
            true,
            'List Transaction',
            Transaction::select(['transactions.*', 'products.name as product_name'])
                ->join('products', 'transactions.product_id', '=', 'products.id')
                ->orderBy('transactions.transaction_date', 'asc')
                ->get()
        );
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
        $transaction = Transaction::with('product')->find($id);
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

    // public function search(Request $request)
    // {
    //     $orderBy = $request->input('order_by');

    //     return new ApiResource(
    //         true,
    //         'List Transaction',
    //         Transaction::with('product')
    //             ->whereHas('product', function ($query) use ($request) {
    //                 $query->where('name', 'like', '%' . $request->q . '%');
    //             })
    //             // ->when($orderBy, function ($query) use ($orderBy) {
    //             //     $query->orderBy($orderBy, 'asc');
    //             // })
    //             ->orderBy('product.name', 'asc')
    //             ->get()
    //     );
    // }

    public function search(Request $request)
    {
        $orderBy = $request->input('order_by') ?? 'transactions.transaction_date';

        return new ApiResource(
            true,
            'List Transaction',
            Transaction::select(['transactions.*', 'products.name as product_name'])
                ->join('products', 'transactions.product_id', '=', 'products.id')
                ->where('products.name', 'like', '%' . $request->q . '%')
                ->orderBy($orderBy, 'asc')
                ->get()
        );
    }
}
