<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIngredients;
use App\Http\Requests\UpdateIngredients;
use App\Models\Ingredients;
use App\Models\Products;
use App\Models\Stock;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    public function store(StoreIngredients $request, string $id)
    {
        DB::beginTransaction();

        try {
            $ingredient = Stock::findOrFail($request->ingredient_id);
            $ingredientName = $ingredient->name;

            if (!$ingredient) {
                return Response()->json([
                    'message' => 'Não há nenhum ingrediente com ID ' . $request->ingredient_id
                ])->setStatusCode(404);
            }

            Ingredients::create([
                'product_id' => $id,
                'ingredient_id' => $request->ingredient_id
            ]);

            DB::commit();

            return Response()->json([
                'message' =>  $ingredientName . ' cadastrado com sucesso'
            ]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            return Response()->json([
                'message' => 'Ingrediente ou produto não encontrado',
                'error' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return Response()->json([
                'message' => 'Houve um erro no sistema ao tentar cadastrar o ingrediente',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        DB::beginTransaction();

        try {
            $product = Products::findOrFail($id)->makeHidden(['created_at', 'updated_at']);

            $ingredients = Ingredients::join('stock', 'ingredients.ingredient_id', '=', 'stock.id')
                ->where('product_id', $id)
                ->select(
                    'ingredients.id',
                    'ingredients.product_id',
                    'stock.id as ingredient_id',
                    'stock.name as ingredient_name',
                    'stock.available as ingredient_available'
                )
                ->get();

            DB::commit();

            return Response()->json([
                'product' => $product,
                'ingredients' => $ingredients
            ])->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            return Response()->json([
                'message' => 'Ingrediente ou produto não encontrado',
                'error' => $e->getMessage()
            ])->setStatusCode(404);
        } catch (\Exception $e) {
            DB::rollBack();

            return Response()->json([
                'message' => 'Houve um erro no sistema ao tentar editar o ingrediente',
                'error' => $e->getMessage()
            ])->setStatusCode(500);
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
    public function update(UpdateIngredients $request, string $product_id, string $ingredient_id)
    {
        DB::beginTransaction();

        try {
            $product = Products::findOrFail($product_id);
            $productID = $product->id;

            $ingredient = Ingredients::findOrFail($ingredient_id);

            if ($ingredient->product_id != $productID) {
                return Response()->json([
                    'message' => 'O ingrediente com ID ' . $ingredient_id . ' não pertence ao produto com ID ' . $product_id
                ])->setStatusCode(404);
            }

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
        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            return Response()->json([
                'message' => 'Ingrediente ou produto não encontrado',
                'error' => $e->getMessage()
            ])->setStatusCode(404);
        } catch (\Exception $e) {
            DB::rollBack();

            return Response()->json([
                'message' => 'Houve um erro no sistema ao tentar editar o ingrediente',
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $product_id, string $ingredient_id)
    {
        DB::beginTransaction();

        try {
            $product = Products::findOrFail($product_id);

            $productID = $product->id;

            $ingredient = Ingredients::findOrFail($ingredient_id);

            if ($ingredient->product_id != $productID) {
                return Response()->json([
                    'message' => 'O ingrediente com ID ' . $ingredient_id . ' não pertence ao produto com ID ' . $product_id
                ])->setStatusCode(404);
            }

            $nameProduct = Products::findOrFail($ingredient->product_id)->name;
            $ingredientName = Stock::findOrFail($ingredient->ingredient_id)->name;

            $ingredient->delete();

            DB::commit();

            return Response()->json([
                'message' => $ingredientName . ' removido com sucesso do produto ' . $nameProduct,
            ])->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            return Response()->json([
                'message' => 'Ingrediente ou produto não encontrado',
                'error' => $e->getMessage()
            ])->setStatusCode(404);
        } catch (\Exception $e) {
            DB::rollBack();

            return Response()->json([
                'message' => 'Houve um erro no sistema ao tentar editar o ingrediente',
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}
