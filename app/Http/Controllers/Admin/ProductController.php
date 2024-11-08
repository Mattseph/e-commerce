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
use Illuminate\Support\Facades\File;
use App\Http\Resources\BrandResource;
use App\Http\Resources\ProductResource;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProductController extends Controller
{

    protected $user_id;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = ProductResource::collection(Product::orderBy('id', 'desc')->get());
        Debugbar::info($products);
        // $products = Product::with([
        //     'category',
        //     'brand',
        //     'product_images',
        // ])->orderBy('id', 'desc')->get();

        $brands = BrandResource::collection(Brand::select('id', 'name')->get());

        $categories = CategoryResource::collection(Category::select('id', 'name')->get());

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

        $this->user_id = Auth::id();

        $validated = $request->validated();

        Debugbar::info($validated);

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'],
            'title' => $validated['title'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'created_by' => $this->user_id,
            'updated_by' => null
        ]);

        $img_data = [];

        if ($request->hasFile('product_images')) {
            $images = $request->file('product_images');

            foreach ($images as $image) {
                // Generate Unique Image Name

                $newImgName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                $image->storeAs('p_images', $newImgName);

                $img_data[] = [
                    'product_id' => $product->id,
                    'image' => 'p_images/' . $newImgName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert all image data in one query
        ProductImage::insert($img_data);

        // Load related images and other necessary relationships for the response
        $product->load('product_images'); // Adjust 'images' if your relationship name is different

        return Inertia::location(
            route('admin.product.index'),
            ['newProduct' => $product],
        );
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


    private function removeImage($id, array $incoming_existing_product_images)
    {
        //Retrieve all of the current product images
        $existing_database_product_images = ProductImage::where('product_id', $id)->pluck('image')->toArray();

        //Comapre the current and request product images

        $images_to_remove = array_diff($existing_database_product_images, $incoming_existing_product_images);

        if (count($images_to_remove) > 0) {

            foreach ($images_to_remove as $image) {

                //Delete the id of current product images that isn't present on request product images. Both Database and Storage

                if (File::exists(storage_path('app/public/' . $image))) {
                    File::delete(storage_path('app/public/' . $image));
                }

                // OR
                // if (Storage::disk('public')->exists($image)) {
                //     Storage::disk('public')->delete($image);
                // }

                ProductImage::where(['image' => $image, 'product_id' => $id])->delete();
            }
        }
    }

    private function insertNewImage($id, array $new_product_images)
    {

        $new_image_data = [];

        foreach ($new_product_images as $image) {
            $new_img_name = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            $image->storeAs('p_images', $new_img_name);

            $new_image_data[] = [
                'product_id' => $id,
                'image' => 'p_images/' . $new_img_name,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        ProductImage::insert($new_image_data);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {

        $this->user_id = Auth::id();

        $validated = $request->validated();

        $product = Product::findOrFail($id);

        $product->update([
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'],
            'title' => $validated['title'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'updated_by' => $this->user_id,
        ]);


        $this->removeImage($id, $validated['existing_product_images'] ?? []);



        if ($request->hasFile('new_product_images')) {
            $this->insertNewImage($id, $request->file('new_product_images'));
        }

        $product->load('product_images'); // Assuming there's a `product_images` relationship on the Product model


        return Inertia::location(route('admin.product.index'), [
            'product' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $product = Product::findOrFail($id);
        $images = $product->product_images()->pluck('image')->toArray();


        //Delete the image in storage
        foreach ($images as $image) {
            $path = storage_path('app/public/' . $image);

            if (File::exists($path)) {
                File::delete($path);
            }
        }
        //Delete the image in ProductImage

        $product->product_images()->delete();

        $product->delete();

        return Inertia::location(route('admin.product.index'), [
            'product' => $product
        ]);
    }
}
