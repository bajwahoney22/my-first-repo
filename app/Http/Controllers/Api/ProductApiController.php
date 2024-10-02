<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\StoreRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductApiController extends Controller
{
    public function index()
    {
        try {
            $products = Product::with(['category:id,name', 'brand:id,name'])->get([
                'id',
                'name',
                'price',
                'size',
                'thumbnail',
                'category_id',
                'brand_id',
            ]);
            $status = 200;
            $data = [
                'success' => true,
                'status' => $status,
                'data' => ProductResource::collection($products)
            ];
        } catch (Exception $exception) {
            $msg = $exception->getMessage();
            Log::error("API Error: Get Product Listing Failed", ['message' => $msg]);
            $status = 500;
            $data = [
                'success' => false,
                'status' => $status,
                'message' => 'Something went wrong. Contact the support.',
                'data' => null
            ];
        }

        return response()->json($data, $status);
    }

    public function show(Product $product)
    {
        $product->load(['category:id,name', 'brand:id,name']);
        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => new ProductResource($product)
        ]);
    }

//     public function store(StoreRequest $request)
// {
//     try {
//         // Validate that the file is an image
//         $request->validate([
//             'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//         ]);

//         // Handle the image upload
//         $imagePath = null;
//         if ($request->hasFile('thumbnail')) {
//             $image = $request->file('thumbnail');
//             $imageName = time() . '.' . $image->getClientOriginalExtension();
//             $imagePath = $image->storeAs('products', $imageName, 'public');
//         }

//         // Create a new product with the image path
//         $product = Product::create([
//             'category_id' => $request->category_id,
//             'brand_id' => $request->brand_id,
//             'name' => $request->name,
//             'price' => $request->price,
//             'size' => $request->size,
//             'thumbnail' => $imagePath ? $imagePath : null,
//         ]);

//         $status = 201;
//         $data = [
//             'success' => true,
//             'status' => $status,
//             'message' => 'The product has been saved!',
//             'data' => new ProductResource($product),
//             'image_url' => $imagePath ? Storage::url($imagePath) : null
//         ];
//     } catch (Exception $exception) {
//         // Log detailed error message
//         Log::error("API Error: Save Product Failed", [
//             'message' => $exception->getMessage(),
//             'file' => $exception->getFile(),
//             'line' => $exception->getLine(),
//         ]);

//         $status = 500;
//         $data = [
//             'success' => false,
//             'status' => $status,
//             'message' => 'Something went wrong. Contact the support.',
//             'error_details' => $exception->getMessage()  // Include detailed error in response for debugging
//         ];
//     }

//     return response()->json($data, $status);
// }
public function store(StoreRequest $request)
{
    try {
        // Validate request
        $request->validate([
            'name' => 'required|string|max:25',
            'price' => 'required|numeric|min:0',
            'size' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        $file = $request->file('thumbnail');
        $time = time();
        $ext = $file->getClientOriginalExtension();
        $filename = "{$time}.{$ext}";
        $path = '/products/thumbnail';
        
        // Store the image in the public disk
        Storage::disk('public')->putFileAs($path, $file, $filename);

        // Create new product with image path
        $product = Product::create([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'price' => $request->price,
            'size' => $request->size,
            'thumbnail' => "{$path}/{$filename}",
        ]);

        $status = 201;
        $data = [
            'success' => true,
            'status' => $status,
            'message' => 'Product created successfully!',
            'data' => new ProductResource($product),
            // 'image_url' => Storage::url("{$path}/{$filename}") // Get URL to show in frontend
        ];

    } catch (Exception $exception) {
        // Log error
        Log::error("API Error: Save Product Failed", [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);

        $status = 500;
        $data = [
            'success' => false,
            'status' => $status,
            'message' => 'Something went wrong. Contact support.',
            'error_details' => $exception->getMessage(),
        ];
    }

    return response()->json($data, $status);
}


    public function delete(Product $product)
    {
        try {
            $deleted = $product->delete();
            $status = $deleted ? 204 : 400;
            $data = [
                'success' => $deleted ? true : false,
                'status' => $status,
                'message' => 'The product has been deleted!'
            ];
        } catch (Exception $exception) {
            $msg = $exception->getMessage();
            Log::error("API Error: deleting Product Failed", ['message' => $msg]);
            $status = 500;
            $data = [
                'success' => false,
                'status' => $status,
                'message' => 'Something went wrong. Contact the support.',
                'data' => null
            ];
        }

        return response()->json($data, $status);
    }
}
