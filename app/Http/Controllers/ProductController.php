<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**$categories = Categories::where('is_deleted', false)->get();
        $products = Products::where('is_deleted', false)->get();  */
        $products = Products::with('category')->where('is_deleted', false)->get();
        
        return view('products', compact('products'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::where('is_deleted', false)->get();
        return view('product-form', compact('categories'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'product_image' => 'nullable|image',
            'product_name' => 'required|unique:products,product_name',
            'category' => 'required|exists:categories,category_id',  
            'price' => 'required|decimal:0,2',
            'stocks' => 'required|integer|min:0',
        ]);
        
        $validated['category_id'] = $request->category;

        if ($request->hasFile('product_image')) {
            $filenameWithExtension = $request->file('product_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('product_image')->getClientOriginalExtension();
            $filenameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('product_image')->storeAs('Uploads/Products Images', $filenameToStore);
            $validated['product_image'] = $filenameToStore;
        }
        
        $product = Products::create($validated);


        if (!$product) {
            return redirect()->route('products')->with([
                'message' => 'Unable to add new product',
                'type' => 'error'
            ]);
        }

        return redirect()->route('products')->with([
            'message' => 'Product added successfully',
            'type' => 'success'
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
    public function edit(string $product_id)
    {
        $product = Products::findorfail($product_id);
        $categories = Categories::where('is_deleted', false)->get();

        return view('product-form', compact('categories', 'product'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $product_id)
    {
        $product = Products::findorfail($product_id);

        $validated = $request->validate([
            'product_image' => 'nullable',
            'product_name' => 'required|unique:products,product_name,'.$product_id. ',product_id',
            'category' => 'required|exists:categories,category_id',  
            'price' => 'required|decimal:0,2',
            'stocks' => 'required|integer|min:0',
        ]);
        
        $validated['category_id'] = $request->category;

        if ($request->hasFile('product_image')) {
            $filenameWithExtension = $request->file('product_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('product_image')->getClientOriginalExtension();
            $filenameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('product_image')->storeAs('Uploads/Products Images', $filenameToStore);
            $validated['product_image'] = $filenameToStore;
        }

        if($product -> update($validated)){
            return redirect()->route('products')->with([
                'message' => 'Product updated successfully',
                'type' => 'success'
            ]);
        };

        return redirect()->route('products')->with([
            'message' => 'Unable to updated product',
            'type' => 'error'
        ]);
    }
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $product_id)
    {
        $product = Products::findorfail($product_id);
         
        $product->is_deleted = true;

        $product->save();

        return redirect()->route('products')->with([
            'message' => 'Product added successfully',
            'type' => 'success'
        ]);
        
    }
}

