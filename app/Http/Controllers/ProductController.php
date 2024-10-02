<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;



class ProductController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();

        return view('product.create', compact('categories', 'brands'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:25',
            'price' => 'required|numeric|min:0',
            'size' => 'required|string|',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $file = $request->file('thumbnail');
        $time = time();
        $ext = $file->getClientOriginalExtension();
        $filename = "{$time}.{$ext}";
        $path = '/products/thumbnail';
        Storage::disk('public')->putFileAs($path, $file, $filename);
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->size = $request->size;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->thumbnail = "{$path}/{$filename}";
        $product->save();

        return back()->with('success', 'Product created successfully');
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->size = $request->size;
        $product->thumbnail = $request->thumbnail;
        $product->update();

        return to_route('product.index');
    }
    
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }
    public function index(Request $request)
{
    $categories = Category::all();
    $brands = Brand::all();
    // $products = Product::query()
    //     ->when($request->category, function($query, $category) {
    //         return $query->where('category_id', $category);
    //     })
    //     ->when($request->brand, function($query, $brand) {
    //         return $query->where('brand_id', $brand);
    //     })
    //     ->paginate(9);
    $products = Product::with(['category', 'brand'])->paginate(9);

    // Provide cart data to the view
    $cart = session('cart', []);

    return view('product.index', compact('categories', 'brands', 'products', 'cart'));
}

}
