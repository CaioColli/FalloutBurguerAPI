<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIngredients;
use App\Models\Ingredients;
use App\Models\Products;
use Illuminate\Http\Request;

class IngredientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreIngredients $request)
    {
        $productID = Products::find($request->product_id);
        $productName = $productID->name;

        $productHasRegistered = Ingredients::where('product_id', $request->product_id)->first();

        if ($productHasRegistered) {
            return Response()->json([
                'message' => 'item ' . $productName . ' já cadastrado'
            ])->setStatusCode(400);
        }

        foreach ($request->ingredient_id as $ingredient) {
            Ingredients::create([
                'product_id' => $request->product_id,
                'ingredient_id' => $ingredient
            ]);
        }

        $productID = Products::find($request->product_id);
        $productName = $productID->name;

        return Response()->json([
            'message' => 'Item ' . $productName . ' cadastrado com sucesso'
        ])->setStatusCode(201);
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
        $productID = Products::find($id);
        $productName = $productID->name;

        Ingredients::where('product_id', $id)->delete();

        return Response()->json([
            'message' => 'Item ' . $productName . ' removido com sucesso'
        ])->setStatusCode(200);
    }
}
