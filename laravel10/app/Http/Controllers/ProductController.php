<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return response()->json(ProductResource::collection($products));
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
        try {

            $validatedData = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string',
                'unit' => 'required|string',
                'price' => 'required|numeric',
            ]);
     
            $product = Product::create($validatedData);
    
            return response()->json($product);
            
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
    public function show(Product $product)
    {
        return response()->json(new ProductResource($product));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        try {

            $validatedData = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string',
                'unit' => 'required|string',
                'price' => 'required|numeric',
            ]);

            $product->update($validatedData);

            return response()->json($product);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ', $e->errors());
            return response()->json($e->errors(), 422);
        } catch (\Exception $e) {
            \Log::error('Unhandled exception: ', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }

    public function delete(Request $request)
    {
        $list = $request->list;
        Product::destroy($list);
    }
}
