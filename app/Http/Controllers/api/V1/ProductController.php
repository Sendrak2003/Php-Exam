<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $token = request()->query('token'); // Retrieve the token from the query parameter

        // Verify and decode the token using the JWTAuth facade
        $user = JWTAuth::parseToken()->authenticate();
        if($user->role_id!=1){
            $products = Product::select('name')->get();
            foreach ($products as $product) {
                $this->authorize('view-product', $product);
            }
            return response()->json([
                'products' => $products
            ]);
        }

        $products = Product::all();
        foreach ($products as $product) {
            $this->authorize('view-product', $product);
        }
        return response()->json([
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getAllBrandsAndModalsSelectedProduct(string $name)
    {
//        $product = Product::where('name', $name)->with('brands', 'models')->first();
//
//        $brands = $product->brands->pluck('name')->toArray();
//        $models = $product->models->pluck('name')->toArray();
//
//        return response()->json([
//            'brands' => $brands,
//            'models' => $models,
//        ]);
        $product = Product::where('name', $name)->get();

        $brandsAndModels = DB::table('brands')
            ->select('brands.name as brand_name', 'models.name as model_name')
            ->join('brand_product_model', 'brands.id', '=', 'brand_product_model.brand_id')
            ->join('models', 'brand_product_model.model_id', '=', 'models.id')
            ->where('brand_product_model.product_id', 3) // Здесь можно использовать $product->id, если он доступен в модели Product
            ->get();

//        return $brandsAndModels;
//        return response()->json([
//            'brands' => $brands,
//            'models' => $models,
//        ]);
    }

}
