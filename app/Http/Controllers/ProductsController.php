<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreService;
use App\Http\Requests\UpdateService;
use App\Models\Products;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::all();

        if ($products->isEmpty()) {
            return Response()->json([
                'messages' => 'Nenhum produto cadastrado'
            ])->setStatusCode(404);
        }

        return Response()->json($products);
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
        ])->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Não há nenhum produto com ID ' . $id
            ])->setStatusCode(404);
        }

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
        $product = Products::find($id);

        if (!$product) {
            return Response()->json([
                'message' => 'Não há nenhum produto com ID ' . $id
            ])->setStatusCode(404);
        }

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
            'message' => $product->name . ' atualizado',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Products::find($id);

        if (!$product) {
            return Response()->json([
                'message' => 'Não há nenhum produto com ID ' . $id
            ])->setStatusCode(404);
        }

        $oldImage = $product->path;
        unlink(public_path('storage/' . $oldImage));

        $product->delete();

        return response()->json([
            'message' => $product->name . ' removido do cardápio',
        ]);
    }
}
