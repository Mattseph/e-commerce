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
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProductController extends Controller
{

    protected $user_id = Auth::user()->id;
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
                ];
            }
        }

        // Insert all image data in one query
        ProductImage::create($img_data);

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
    public function update(ProductUpdateRequest $request, string $id)
    {

        Debugbar::info($request->all());

        $validated = $request->validated();


        Product::where('id', $id)->update([
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'],
            'title' => $validated['title'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'updated_by' => $this->user_id,
        ]);


        //Retrieve all of the current product images
        $existing_product_images = ProductImage::where('product_id', $id)->pluck('image')->toArray();

        //Get all of the request product images

        //Comapre the current and request product images

        if ($request->hasFile('product_images')) {
            $incoming_product_images = $request->file('product_images');

            // Extract only the original filenames of incoming images for comparison
            $incoming_image_names = array_map(fn($image) => $image->getClientOriginalName(), $incoming_product_images);

            $images_to_remove = array_filter($existing_product_images, function ($image) use ($incoming_image_names) {
                return !in_array(basename($image), $incoming_image_names);
            });

            // Determine images to add: incoming images that are not already in the database
            $images_to_add = array_filter($incoming_product_images, function ($image) use ($existing_product_images) {
                return !in_array('p_images/' . $image->getClientOriginalName(), $existing_product_images);
            });


            if ($images_to_remove > 0) {

                foreach ($images_to_remove as $image) {

                    //Delete the id of current product images that isn't present on request product images. Both Database and Storage
                    File::delete($image);

                    ProductImage::where(['image' => $image, 'product_id' => $id])->delete();
                }
            }


            if ($images_to_add > 0) {
                $new_image_data = [];

                foreach ($images_to_add as $image) {
                    $new_img_name = time() . '-' . Str::random(10) . '-' . $image->getClientOriginalExtension();

                    $image->storeAs('p_image', $new_img_name);

                    $new_image_data[] = [
                        'product_id' => $id,
                        'image' => 'p_images/' . $new_img_name,
                    ];
                }

                ProductImage::create($new_image_data);
            }
        }



        //Insert the new product images





    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
