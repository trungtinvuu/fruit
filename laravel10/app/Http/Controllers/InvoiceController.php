<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\InvoiceRepository;
use App\Models\Product;

class InvoiceController extends Controller
{
    protected $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customerName = $request->customer_name;
        $products = $request->products;

        try {
            $validatedData = $request->validate([
                'customer_name' => 'required|string',
            ]);
    
            $invoice = Invoice::create($validatedData);
    
            foreach ($products as $arr) {
                $quantity = $arr["quantity"];
                $product = Product::find($arr["id"]);
                $this->invoiceRepository->attachProduct($invoice,$product,$quantity);
            }

            return response()->json($invoice);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ', $e->errors());
            return response()->json($e->errors(), 422);
        } catch (\Exception $e) {
            \Log::error('Unhandled exception: ', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
