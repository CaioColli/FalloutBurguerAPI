<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateIngredients;
use App\Models\Ingredients;
use App\Models\Products;
use App\Models\Stock;
use GuzzleHttp\Psr7\Response;
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
    public function store(Request $request)
    {
        //
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
    public function update(UpdateIngredients $request, string $id)
    {
        $ingredient = Ingredients::find($id);
        
        $ingredient->ingredient_id = $request->ingredient_id ?? $ingredient->ingredient_id;
        $ingredient->save();

        $availableIgredient = Stock::find($request->ingredient_id)->available;
        $nameIngredient = Stock::find($request->ingredient_id)->name;

        $nameProduct = Products::find($ingredient->product_id)->name;

        if (!$availableIgredient) {
            $product = Products::find($ingredient->product_id);
            $product->available = false;
            $product->save();

            return Response()->json([
                'message' => 'O ingrediente ' . $nameIngredient . ' está em falta no estoque, o produto ' . $nameProduct . ' foi desativado'
            ])->setStatusCode(200);
        }

        return Response()->json([
            'message' => 'Ingrediente atualizado com sucesso',
        ])->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ingredient = Ingredients::find($id);

        $nameProduct = Products::find($ingredient->product_id)->name;
        $ingredientName = Stock::find($ingredient->ingredient_id)->name;

        $ingredient->delete();

        return Response()->json([
            'message' => $ingredientName . ' removido com sucesso do produto ' . $nameProduct,
        ])->setStatusCode(200);
    }
}
