<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::paginate(4);
        // En compact ponemos el nombre con el que llamaremos en el index
        return view('products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required', 'description' => 'required', 'img' =>'required|img|mimes:webp,jpeg,jpg,png,svg|max:1024'
        ]);
        $product = $request->all();

        if ($img = $request->file('imgn')){
            $imgUrl = 'img/';
            $productImg = date('YmdHis'). "." . $img->getClientOriginalExtension();
            $img->move($imgUrl, $productImg);
            $product['img'] = "$productImg";
        }
        Products::create($product);
        return redirect()->route('products.create');
        
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
