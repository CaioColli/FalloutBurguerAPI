<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateIngredients;
use App\Models\Ingredients;
use App\Models\Products;
use App\Models\Stock;
use Illuminate\Http\Request;

class IngredientsController extends Controller
{
    private function validateIngredient($id) {
        abort(Response()->json([
            'message' => 'Não há nenhum produto com ID ' . $id
        ])->setStatusCode(404));
    }
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
        $ingredient = Products::find($id);

        if (!$ingredient) {
            $this->validateIngredient($id);
        }

        $ingredients = Ingredients::join('stock', 'ingredients.ingredient_id', '=', 'stock.id')
            ->where('product_id', $id)
            ->select(
                'ingredients.id',
                'ingredients.product_id',
                'stock.name',
                'stock.available'
            )
            ->get();

        return Response()->json($ingredients)->setStatusCode(200);
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
        DB::beginTransaction();

        try {
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

                DB::commit();

                return Response()->json([
                    'message' => 'O ingrediente ' . $nameIngredient . ' está em falta no estoque, o produto ' . $nameProduct . ' foi desativado'
                ])->setStatusCode(200);
            }

            DB::commit();

            return Response()->json([
                'message' => 'O Ingrediente do produto ' . $nameProduct . ' foi atualizado com sucesso',
            ])->setStatusCode(200);
        } catch (\Exception $e) {
            DB::rollBack();

            return Response()->json([
                'message' => 'Houve um erro no sistema ao tentar editar o ingrediente'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ingredient = Ingredients::find($id);

        if (!$ingredient) {
            $this->validateIngredient($id);
        }

        $nameProduct = Products::find($ingredient->product_id)->name;
        $ingredientName = Stock::find($ingredient->ingredient_id)->name;

        $ingredient->delete();

        return Response()->json([
            'message' => $ingredientName . ' removido com sucesso do produto ' . $nameProduct,
        ])->setStatusCode(200);
    }
}
