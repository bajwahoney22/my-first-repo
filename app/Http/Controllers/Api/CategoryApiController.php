<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class CategoryApiController extends Controller
{
//     public function index()
//     {
//         return response()->json([
//             'success' => true,
//             'status' => 200,
//             'data' => Category::all()
//         ]);
// }
public function index()
    {
        try{
            $products = Brand::get(['id','name']);
            $status = 200;
            $data = [
                'success' => true,
                'status' => $status,
                'data' => Category::get(['id','name'])
                // 'data' => ProductResource::collection($products)
            ];

        }
        catch(Exception $exception){
            $msg = $exception->getMessage();
            // Log::error("API: {$msg}", ['Description' => 'An error occured while getting the products in GET PRODUCT LISTING']);
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
        // ->json([
        //     'success' => true,
        //     'status' => 200,
        //     'data' => Category::get(['id','name'])
        // ]);
}

public function store(Request $request){
    try {
        Category::create([
            'id' => $request->id,
            'name' => $request->name,
            
        ]);
        $status = 201;
        $data = [
            'success' => true,
            'status' => $status,
            'message' => 'The product has been saved!'
        ];
    } catch (Exception $exception) {
        $msg = $exception->getMessage();
        // Log::error("API: {$msg}", ['Description' => 'An error occurred while getting the products in GET PRODUCT LISTING']);
        Log::error("API Error: Save Product Failed", ['message' => $msg]);
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
// public function destroy(Request $request)
// {
//     try {
//         Category::destroy([
//            'id'=> $request->id,
//             'name' => $request->name,
//         ]);
//         $status = 201;
//         $data = [
//             'success' => true,
//             'status' => $status,
//             'message' => 'The product has been delete!'
//         ];
//     } catch (Exception $exception) {
//         $msg = $exception->getMessage();
//         // Log::error("API: {$msg}", ['Description' => 'An error occurred while getting the products in GET PRODUCT LISTING']);
//         Log::error("API Error: destroying Product Failed", ['message' => $msg]);
//         $status = 500;
//         $data = [
//             'success' => false,
//             'status' => $status,
//             'message' => 'Something went wrong. Contact the support.',
//             'data' => null
//         ];
//     }

//     return response()->json($data, $status);
// }
public function delete(Category $category)
    {
        try {
            $deleted = $category->delete();
            $status = $deleted ? 204 : 400;
            $data = [
                'success' => $deleted ? true: false,
                'status' => $status,
                'message' => 'The product has been delete!'
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