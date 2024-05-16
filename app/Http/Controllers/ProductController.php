<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::all(); // Retrieve all products from the database
        return view('products.index', compact('products')); // Pass the products to the view
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product')); // Pass the product to the view
    }
}
