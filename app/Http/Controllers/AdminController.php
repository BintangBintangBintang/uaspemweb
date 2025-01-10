<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Intervention\Image\Laravel\Facades\Image;
class AdminController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        $galleryImages = $product->images ? json_decode($product->images, true) : [];

        return view('admin.product_show', compact('product', 'galleryImages'));
    }

    public function products()
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function product_add()
    {
        return view('admin.product_add');
    }

    private function generateThumbnailImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/products');
        $destinationPathThumbnail = public_path('uploads/products/thumbnails');

        $img = Image::read($image);

        $img->resize(540, 689)->save($destinationPath . '/' . $imageName);

        $img->resize(104, 104)->save($destinationPathThumbnail . '/' . $imageName);
    }

    public function product_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            'images.*' => 'mimes:png,jpg,jpeg|max:2048',
        ]);


        $product = new Product();
        $product->fill($request->only([
            'name',
            'short_description',
            'description',
            'regular_price',
            'sale_price',
            'SKU',
            'stock_status',
            'featured',
            'quantity'
        ]));
        $product->slug = Str::slug($request->name);

        $currentTimestamp = time();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $currentTimestamp . '.' . $image->extension();
            $this->generateThumbnailImage($image, $imageName);
            $product->image = $imageName;
        }

        $galleryImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                $imageName = $currentTimestamp . '-' . ($key + 1) . '.' . $file->extension();
                $this->generateThumbnailImage($file, $imageName);
                $galleryImages[] = $imageName;
            }
        }
        $product->images = implode(',', $galleryImages);

        $product->save();

        return redirect()->route('admin.products')->with('status', 'Record has been added successfully!');
    }

    public function edit_product($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product_edit', compact('product'));
    }

    public function update_product(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $request->id,
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required|integer',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'images.*' => 'mimes:png,jpg,jpeg|max:2048',
        ]);

        $product = Product::findOrFail($request->id);
        $product->fill($request->only([
            'name',
            'short_description',
            'description',
            'regular_price',
            'sale_price',
            'SKU',
            'stock_status',
            'featured',
            'quantity'
        ]));
        $product->slug = Str::slug($request->name);

        $currentTimestamp = time();

        // Update Main Image
        if ($request->hasFile('image')) {
            File::delete(public_path('uploads/products/' . $product->image));
            File::delete(public_path('uploads/products/thumbnails/' . $product->image));

            $image = $request->file('image');
            $imageName = $currentTimestamp . '.' . $image->extension();
            $this->generateThumbnailImage($image, $imageName);
            $product->image = $imageName;
        }

        // Update Gallery Images
        if ($request->hasFile('images')) {
            foreach (explode(',', $product->images) as $gImage) {
                File::delete(public_path('uploads/products/' . $gImage));
                File::delete(public_path('uploads/products/thumbnails/' . $gImage));
            }

            $galleryImages = [];
            foreach ($request->file('images') as $key => $file) {
                $imageName = $currentTimestamp . '-' . ($key + 1) . '.' . $file->extension();
                $this->generateThumbnailImage($file, $imageName);
                $galleryImages[] = $imageName;
            }
            $product->images = implode(',', $galleryImages);
        }

        $product->save();

        return redirect()->route('admin.products')->with('status', 'Record has been updated successfully!');
    }

    public function delete_product($id)
    {
        $product = Product::findOrFail($id);

        // Delete Main Image
        File::delete(public_path('uploads/products/' . $product->image));
        File::delete(public_path('uploads/products/thumbnails/' . $product->image));

        // Delete Gallery Images
        foreach (explode(',', $product->images) as $gImage) {
            File::delete(public_path('uploads/products/' . $gImage));
            File::delete(public_path('uploads/products/thumbnails/' . $gImage));
        }

        $product->delete();

        return redirect()->route('admin.products')->with('status', 'Record has been deleted successfully!');
    }

    public function orders()
{
        $orders = Order::orderBy('created_at','DESC')->paginate(12);
        return view("admin.orders",compact('orders'));
}
}
