<?php

namespace App\Http\Controllers;
use App\Models\Product;


use Illuminate\Http\Request;

class ShopController extends Controller
{
    // ShopController.php

    public function index(Request $request)
    {

        $search = $request->input('search-keyword');


        if ($search) {
            $products = Product::where('name', 'like', '%' . $search . '%')->get();
        } else {

            $products = Product::all();
        }

        return view('shop', compact('products'));
    }


    public function product_details($product_slug)
    {
        $product = Product::where("slug", $product_slug)->first();
        $rproducts = Product::where("slug", "<>", $product_slug)->get()->take(8);
        return view('details', compact("product", "rproducts"));
    }

}
