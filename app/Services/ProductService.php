<?php

namespace App\Services;

use App\Models\Product;

class ProductService {

    public function calculateStockChange(string $type, int $quantity, int $quantityOld = 0) : int
    {
        $stockChange = 0;
        switch ($type) {
            case 'store':
                $stockChange -= $quantity;
                break;
            case 'update':
                $stockChange += $quantityOld - $quantity;
                break;
            case 'delete':
                $stockChange += $quantity;
                break;
            default:
                # code...
                break;
        }
        return $stockChange;
    }

    public function updateStock(int $stockChange, Product $product)
    {
        $product->stock += $stockChange;
        $product->save();
    }

}
