<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class HomeController extends Controller
{
   
    public function index()
{
    $featuredProducts = Product::where('featured', 1)->get();
    return view('index', compact('featuredProducts'));
}

    
}
