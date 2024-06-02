<?php

namespace App\Http\Controllers\api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $products = Product::all();

            return[
                "status" => 200,
                "message" => "success",
                "data" => $products
            ];
        }catch(\Exception $e){
            return[
                "status" => 400,
                "message" => "error",
                "error" => $e
            ];
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          try{
            $request->validate([
                "name" => 'required|string',
                "qty" => 'required|integer',
                "description" => 'required|string',
                "price" => 'required|integer',
                "photo" => 'required|'
            ]);
            
            $filenameExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameSave = $filename.'_'.time().'.'.$extension;
            $request->file('photo')->storeAs('public/productPhoto', $filenameSave);

            $product = Product::create([
                'name' => $request->name,
                'qty' => $request->qty,
                'description' => $request->description,
                'price' => $request->price,
                'photo' => $filenameSave,
            ]);

             return[
                "status" => 200,
                "message" => "success",
                "data" => $product
            ];
        }catch(\Exception $e){
            return[
               "status" => 400,
               "message" => "error",
               "error" => $e
           ];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $product = Product::find($id);

            return[
                "status" => 200,
                "message" => "success",
                "data" => $product
            ];
        }catch(\Exception $e){
            return[
                "status" => 400,
                "message" => "error",
                "error" => $e
            ];
        }
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
         try{
            $product = Product::find($id);

            $request->validate([
                "name" => 'required|string',
                "qty" => 'required|integer',
                "description" => 'required|string',
                "price" => 'required|integer',
            ]);
            
            if($request->file('photo')){
                if(Storage::disk('public')->exists('articlePhoto/'. $product->photo)){
                    Storage::disk('public')->delete('articlePhoto/'. $product->photo);
                }
                $filenameExt = $request->file('photo')->getClientOriginalName();
                $filename = pathinfo($filenameExt, PATHINFO_FILENAME);
                $extension = $request->file('photo')->getClientOriginalExtension();
                $filenameSave = $filename.'_'.time().'.'.$extension;
                $request->file('photo')->storeAs('public/productPhoto', $filenameSave);
                
                $product->update(['photo' => $filenameSave]);

            }

            $product->update([
                'name' => $request->name,
                'qty' => $request->qty,
                'description' => $request->description,
                'price' => $request->price,
            ]);

             return[
                "status" => 200,
                "message" => "success",
                "data" => $product
            ];
        }catch(\Exception $e){
            return[
               "status" => 400,
               "message" => "error",
               "error" => $e->getMessage()
           ];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
         try{
            $product = Product::find($id);
                if(Storage::disk('public')->exists('articlePhoto/'. $product->photo)){
                    Storage::disk('public')->delete('articlePhoto/'. $product->photo);
                }
            $product->delete();

             return[
                "status" => 200,
                "message" => "Success delete product",
            ];
        }catch(\Exception $e){
            return[
               "status" => 400,
               "message" => "error",
               "error" => $e
           ];
        }
    }
}
