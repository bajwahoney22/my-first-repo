<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BrandController extends Controller
{

public function create()
{
    return view('brands.create');
}

public function store(Request $request)
{
     $request->validate([
        'name' => 'required|string|max:255',
    ]);
    $brand = new Brand();
    $brand->name = $request->name;
    $brand->save();
    
    return back();
}

public function index(): View
{   
    $brands = Brand::withCount('products')->get(['id', 'name']);
    $data = compact('brands');
    return view('brands.index', $data);
}
public function edit($id)
{
    $brand = Brand::findOrFail($id);
    return view('brands.edit', compact('brand'));
}

public function update(Request $request, $id)
{
    $brand = Brand::findOrFail($id);
    $brand->name = $request->name;
    $brand->save();

    return redirect()->route('brands.index');
}

public function destroy(Brand $brand)
{
    $brand->delete();
    return redirect()->route('brands.index')->with('success', 'Brand deleted successfully');
}
}
