<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Product;

/**
 * Class ProductController.
 *
 * @author Jan Arambulo <arambulo@jan.com>
 * @package App\Http\Controllers\Admin
 */
class ProductController extends Controller
{
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    public function show(Product $product)
    {
        return ProductResource::make($product);
    }
}
