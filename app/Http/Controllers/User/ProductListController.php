<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Inertia\Inertia;

class ProductListController extends Controller
{
    public function index()
    {
//        $users = User::popular()->active()->orderBy('created_at')->get();

        $filteredProducts = Product::filtered()->with('category', 'product_images')->paginate(9)->withQueryString();
//        $products = Product::with('category', 'product_images');
//        $filteredProducts = $products->filtered()->paginate(9)->withQueryString();

        return Inertia::render(
            'User/ProductList',
            [
                'categories' => Category::get(),
                'products'   => ProductResource::collection($filteredProducts)
            ]
        );
    }
}
