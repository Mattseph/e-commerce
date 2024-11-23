<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

class UserController extends Controller
{
    public function index () {

        $products = ProductResource::collection(Product::InStock()->orderBy('id', 'desc')->limit(5)->get());

        return Inertia::render('User/Index', [
            'products' => $products,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);

    }
}
