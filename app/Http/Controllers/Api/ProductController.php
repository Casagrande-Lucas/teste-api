<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $supplierProduct;

    public function __construct(SupplierProduct $supplierProduct)
    {
        $this->supplierProduct = $supplierProduct;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function index(Supplier $supplier)
    {
        return $supplier->products;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Supplier $supplier
     * @param  Product $product
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Supplier $supplier, Product $product)
    {
        $this->supplierProduct->create([
            'supplier_id' => $supplier->id,
            'product_id' => $product->id,
        ]);

        $request = $request->all();
        $request['supplier_id'] = $supplier->id;

        return $product->create($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  Supplier $supplier
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier, Product $product)
    {
        return $product->where([
            ['supplier_id', $supplier->id],
            ['id', $product->id],
        ])->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Supplier $supplier
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier, Product $product)
    {
        $product->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Supplier $supplier
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier, Product $product)
    {
        $this->supplierProduct->delete([
            ['supplier_id', $supplier->id],
            ['product_id', $product->id],
        ]);

        return $product->delete([
            ['supplier_id', $supplier->id],
            ['id', $product->id],
        ]);
    }
}
