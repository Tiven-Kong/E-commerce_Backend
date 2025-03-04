<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::all();

        return response()->json([
            "data" => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);

        $image_path = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image_path = $image->storeAs('productImage', $image_name, 'public');
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image_path,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);

        // Generate full image URL
        $product->image = url(Storage::url($image_path));

        return response()->json([
            'productdata' => $product,
            'message' => 'Product created successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $find = Product::find($id);

        if (!$find) {
            return response()->json(['message' => 'Cannot find the product you want to update']);
        }

        $find->update($request->all());

        return response()->json(['message' => 'Product updated successfully']);
    }

    public function destroy($id)
    {
        $find = Product::find($id);

        if (!$find) {
            return response()->json(['message' => 'Cannot find the product you want to delete']);
        }

        // Delete the image file from storage
        Storage::delete('public/' . $find->image);

        $find->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
