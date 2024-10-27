<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::select('title', 'category_id', 'brand_id', 'inStock', 'price')->with([
            'category',
            'brand'
        ])->get();

        $brands = Brand::select('id', 'name')->get();

        $categories = Category::select('id', 'name')->get();


        return Inertia::render('Admin/Product/Index', [
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin.Product.Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $validated = $request->validated();

        $product = Product::create($validated);

        if ($validated->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                // Generate Unique Image Name

                $newImgName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                $image->move('product_images', $newImgName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'product_images/' . $newImgName,
                ]);
            }
        }

        return Inertia::render('Admin/Product/Index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
}
