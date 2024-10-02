<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $product = new Category();
        $product->name = $request->name;
        $product->save();

        return back();
    }

    public function index(): View
    {
        // $products = Category::with(['products'])->get(['id', 'name']);
        $products = Category::withCount('products')->get(['id', 'name']);
        $data = compact('products');
        return view('categories.index', $data);
    }

    public function edit($id)
    {
        $product = Category::findOrFail($id);
        return view('categories.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Category::findOrFail($id);
        $product->name = $request->name;
        $product->update();

        return to_route('categories.index');
    }

    public function destroy(Category $category)
{
    $category->delete();
    return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
}
public function showProductForm()
{
    $categories = Category::all(); // Assuming you have a Category model
    return view('product.form', compact('categories'));
}
    

    
}
