<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request) {
        return view('Admin.search', ['q' => $request->query('q')]);
    }
}

