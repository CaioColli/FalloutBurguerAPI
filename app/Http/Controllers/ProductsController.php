<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreService;
use App\Http\Requests\UpdateService;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
    public function store(StoreService $request)
    {
        $file = $request->file('file')->store('products', 'public');

        Products::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'available' => $request->available,
            'path' => $file
        ]);

        return response()->json([
            'message' => $request->name . ' cadastrado com sucesso',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Products::findOrFail($id);

        return response()->json($product);
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
    public function update(UpdateService $request, $id)
    {
        $product = Products::findOrFail($id);

        $product->name = $request->name ?? $product->name;
        $product->description = $request->description ?? $product->description;
        $product->price = $request->price ?? $product->price;
        $product->available = $request->available ?? $product->available;

        if ($request->hasFile('file')) {
            $file = $request->file('file')->store('products', 'public');

            $oldImage = $product->path;
            unlink(public_path('storage/' . $oldImage));

            $product->path = $file;
        }

        $product->save();

        return response()->json([
            'message' => $product->name . ' atualizado com sucesso',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
