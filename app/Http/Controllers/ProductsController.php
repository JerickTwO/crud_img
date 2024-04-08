<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\Storage;



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
            'name' => 'required', 
            'description' => 'required',
            'img' =>'required|image|mimes:webp,jpeg,jpg,png,svg|max:1024', 
        ]);

        // Obtiene la extensión de la imagen
        $extension = $request->file('img')->extension();

        // Genera un nombre único basado en la fecha y hora actual
        $imageName = date('YmdHis') . '.' . $extension;

        // Almacena la imagen en la carpeta storage/app/public con el nombre único
        $imagePath = $request->file('img')->storeAs('public/products', $imageName);

        // Genera la URL para acceder a la imagen
        $imagenUrl = Storage::url($imagePath);

        // Crea un nuevo objeto product con los datos proporcionados
        $product = new Products();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->img = $imagenUrl;
        $product->save();
        
        return redirect()->route('products.index');//->with('success', 'product creado exitosamente.');


            // $products = $request->all();

            // if($img = $request->file('img')){
            //     $imgUrl = 'img/';
            //     $productImg = date('YmdHis'). "." . $img ->getClientOriginalExtension();
            //     $img ->move($imgUrl, $productImg);  
            //     $products['img'] = "$productImg";
            // }
            // dd($products);

            // Products::create($products);
            // return redirect()->route('products.index');
        
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
    public function edit(Products $product)
    {
        return view('products.edit',compact('product'));   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $product = Products::findOrFail($id);

        // Si se proporciona una nueva imagen, actualiza la imagen
        if ($request->hasFile('img')) {
            // Elimina la imagen anterior si existe
            if ($product->img) {
                Storage::delete(str_replace('storage/', 'public/', $product->img));
            }

            // Obtiene la extensión de la nueva imagen
            $extension = $request->file('img')->extension();

            // Genera un nombre único basado en la fecha y hora actual
            $imageName = date('YmdHis') . '.' . $extension;

            // Almacena la nueva imagen en la carpeta storage/app/public con el nombre único
            $imagenPath = $request->file('img')->storeAs('public/productes', $imageName);

            // Genera la URL para acceder a la nueva imagen
            $imagenUrl = Storage::url($imagenPath);

            // Actualiza la imagen del celular en la base de datos
            $product->img = $imagenUrl;
        }

        // Actualiza los otros datos del celular
        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();

        return redirect()->route('products.index');//->with('success', 'Celular actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $product)
    {

        // Elimina la imagen asociada si existe
        if ($product->img) {
            Storage::delete(str_replace('storage/', 'public/', $product->img));
        }

        // Elimina el celular de la base de datos
        $product->delete();

        return redirect()->route('products.index');//->with('success', 'Celular eliminado exitosamente.');

    }
}
