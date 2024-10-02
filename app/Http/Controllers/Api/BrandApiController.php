<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BrandApiController extends Controller
{
//     public function index()
//     {
//         return response()->json([
//             'success' => true,
//             'status' => 200,
//             'data' => Brand::all()
//         ]);
// }
//     public function index()
//     {
//         return response()->json([
//             'success' => true,
//             'status' => 200,
//             'data' => Brand::get(['id','name'])
//         ]);
// }
//  public function index(){
//         $products = Brand::all();
//         return response($products);
//     }
public function index()
    {
        try{
            $products = Brand::get(['id','name','created_at','updated_at']);
            $status = 200;
            $data = [
                'success' => true,
                'status' => $status,
                'data' => Brand::get(['id','name','created_at','updated_at'])
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
}
public function store(Request $request){
    try {
        Brand::create([
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
public function delete(Brand $brand)
    {
        try {
            $deleted = $brand->delete();
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