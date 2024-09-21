<?php

namespace App\Http\Controllers;
use App\Http\Controllers\api\V1\AuthController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('jwt.auth')->except('index');
    }

    public function index()
    {
        return view('welcome');
    }
    public function home(Request $request)
    {
        $token = request()->query('token');
       // $token = $request->header('Authorization');
        $user = JWTAuth::parseToken()->authenticate();
        $passportNumber=$user->passportNumber;
        $categories = Category::select('name')->get();
        $products = Product::select('brand','model','price')->get();

        $data = [
            'token' => $token,
            'passportNumber' => $passportNumber,
            'categories' => $categories,
            'products' => $products,
        ];

        return view('home', compact('data'));
    }
//    public function logout()
//    {
//        //redirect()->route('index');
//        return redirect()->route('index');
//    }

}
