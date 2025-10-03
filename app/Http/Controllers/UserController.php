<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class UserController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->latest()->paginate(12);
        return view('user.index',compact('products'));
    }
}
