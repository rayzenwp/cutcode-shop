<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {    
    //Query builder 
    dump(Product::query()
        ->select('id', 'title', 'brand_id')
        ->with(['categories', 'brand'])
        ->where('id', 1)
        // ->toSql()
        ->get()
    );

    return view('welcome');
});
