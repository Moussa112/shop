<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

use function redirect;
use function time;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'product_images')->get();
        $categories = Category::get();

        return Inertia::render(
            'Admin/Product/Index',
            [
                'products'   => $products,
                'categories' => $categories,
            ]
        );
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->with('category', 'product_images')->firstOrFail();

        return Inertia::render('Product/Show', ['product' => $product]);
    }

    public function store(Request $request)
    {
        $product              = new Product;
        $product->title       = $request->title;
        $product->description = $request->description;
        $product->price       = $request->price;
        $product->category_id = $request->category_id;
        $product->save();

        if ($request->hasFile('product_images')) {
            $images = $request->file('product_images');

            foreach ($images as $image) {
                $now = new DateTime('now');
                $dir = $now->format('Y') . '/' . $now->format('m') . '/' . $now->format('d') . '/';
                $name = $dir . time() . '-' . Str::random(4) . '.' . $image->getClientOriginalExtension();

                $image->move('product_images/' . $dir, $name);

                ProductImage::create([
                   'product_id' => $product->id,
                   'image'      => 'product_images/' . $name
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully.');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->title       = $request->title;
        $product->description = $request->description;
        $product->price       = $request->price;
        $product->category_id = $request->category_id;

        if ($request->hasFile('product_images')) {
            $images = $request->file('product_images');

            foreach ($images as $image) {
                $now = new DateTime('now');
                $dir = $now->format('Y') . '/' . $now->format('m') . '/' . $now->format('d') . '/';
                $name = $dir . time() . '-' . Str::random(4) . '.' . $image->getClientOriginalExtension();

                $image->move('product_images/' . $dir, $name);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image'      => 'product_images/' . $name
                ]);
            }
        }

        $product->update();

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    public function deleteImage($id)
    {
        ProductImage::where('id', $id)->delete();

        return redirect()->route('admin.products.index')->with('success', 'Image deleted successfully.');
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
