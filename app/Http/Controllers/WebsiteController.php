<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class WebsiteController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])->paginate();
        $categories = Category::all();
        $brands = Brand::all();
        $cartCount = Cart::Count();

        return view('filter.index', compact('products', 'categories', 'brands','cartCount'));
    }
    public function filterByCategory($id)
    {
        $products = Product::with(['category', 'brand'])->where('category_id', $id)->paginate(4);
        $categories = Category::all();
        $brands = Brand::all();
        $cartCount = Cart::count();
        return view('filter.index', compact('products', 'categories', 'brands','cartCount'));
    }

    public function filterByBrand($id)
    {
        $products = Product::with(['category', 'brand'])->where('brand_id', $id)->paginate(4);
        $categories = Category::all();
        $brands = Brand::all();
        $cartCount = Cart::count();
        return view('filter.index', compact('products', 'categories', 'brands','cartCount'));
    }

public function filterProducts(Request $request)
{
    $categoryIds = $request->input('categories', []);
    $brandIds = $request->input('brands', []);

    $query = Product::with(['category', 'brand']);

    if (!empty($categoryIds)) {
        $query->whereIn('category_id', $categoryIds);
    }

    if (!empty($brandIds)) {
        $query->whereIn('brand_id', $brandIds);
    }
    

    $products = $query->paginate(); 
    $categories = Category::all();
    $brands = Brand::all();
    $cartCount = Cart::count();
    return view('filter.index', compact('products', 'categories', 'brands','cartCount'));
}


}    