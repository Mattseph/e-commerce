<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Requests\Product\ProductStoreRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with([
            'category',
            'brand',
            'product_images',
        ])->orderBy('id', 'desc')->get();

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
        $user_id = Auth::user()->id;
        $validated = $request->validated();

        Debugbar::info($validated);

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'],
            'title' => $validated['title'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'created_by' => $user_id,
            'updated_by' => null
        ]);

        if ($request->hasFile('product_images')) {
            $images = $request->file('product_images');

            foreach ($images as $image) {
                // Generate Unique Image Name

                $newImgName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                $image->storeAs('p_images', $newImgName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'p_images/' . $newImgName,
                ]);
            }
        }

        // Load related images and other necessary relationships for the response
        $product->load('product_images'); // Adjust 'images' if your relationship name is different

        return Inertia::location(route('admin.product.index'), [
            'newProduct' => $product,
        ]);
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
