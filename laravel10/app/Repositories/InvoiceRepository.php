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
}
