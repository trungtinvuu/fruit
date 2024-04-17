<?php

namespace App\Repositories;

use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class InvoiceRepository
{
    public function attachProduct(Invoice $invoice, Product $product, $quantity)
    {
        $invoice->products()->attach($product,['quantity' => $quantity]);
    }

    public function attachProducts(Invoice $invoice, array $products)
    {
        foreach ($products as $arr) {
            $quantity = $arr["quantity"];
            $product = Product::find($arr["id"]);
            $invoice->products()->attach($product,['quantity' => $quantity]);
        }
    }

    public function syncProducts(Invoice $invoice, array $products)
    {
        $list = [];
        foreach ($products as $arr) {
            $quantity = $arr["quantity"];
            $id = $arr["id"];
            $list[$id] = ['quantity' => $quantity];
        }
        $invoice->products()->sync($list);
    }
}
