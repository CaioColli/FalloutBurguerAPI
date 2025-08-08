<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDrinks;
use App\Http\Requests\UpdateDrink;
use App\Models\Drinks;
use Illuminate\Http\Request;

class DrinksController extends Controller
{
    private function validateProduct($id)
    {
        abort(Response()->json([
            'message' => 'Não há nenhum produto com ID ' . $id
        ])->setStatusCode(404));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drinks = Drinks::all();

        if ($drinks->isEmpty()) {
            return Response()->json([
                'messages' => 'Nenhum produto cadastrado'
            ])->setStatusCode(404);
        }

        return Drinks::all();
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
    public function store(StoreDrinks $request)
    {
        DB::beginTransaction();

        try {
            $file = $request->file('file')->store('products', 'public');

            Drinks::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'available' => true,
                'path' => $file
            ]);

            DB::commit();

            return response()->json([
                'message' => $request->name . ' cadastrado com sucesso',
            ])->setStatusCode(201);
        } catch (\Exception $e) {
            DB::rollBack();

            return Response()->json([
                'message' => 'Houve um erro no sistema ao tentar cadastrar o produto'
            ])->setStatusCode(500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $drink = Drinks::find($id);

        if (!$drink) {
            $this->validateProduct($id);
        }

        return Response()->json($drink)->setStatusCode(200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $drink = Drinks::find($id);

        if (!$drink) {
            return $this->validateProduct($id);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDrink $request, string $id)
    {
        DB::beginTransaction();

        try {
            $drink = Drinks::find($id);

            if (!$drink) {
                $this->validateProduct($id);
            }

            $drink->name = $request->name ?? $drink->name;
            $drink->description = $request->description ?? $drink->description;
            $drink->price = $request->price ?? $drink->price;
            $drink->available = $request->available ?? $drink->available;

            if ($request->hasFile('file')) {
                $file = $request->file('file')->store('products', 'public');

                $oldImage = $drink->path;
                unlink(public_path('storage/' . $oldImage));

                $drink->path = $file;
            }

            $drink->save();

            DB::commit();

            return response()->json([
                'message' => $drink->name . ' atualizado',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return Response()->json([
                'message' => 'Houve um erro no sistema ao tentar editar o produto'

            ])->setStatusCode(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $drink = Drinks::find($id);

            if (!$drink) {
                $this->validateProduct($id);
            }

            $oldImage = $drink->path;
            unlink(public_path('storage/' . $oldImage));

            $drink->delete();

            DB::commit();

            return response()->json([
                'message' => $drink->name . ' removido do cardápio',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return Response()->json([
                'message' => 'Houve um erro no sistema ao tentar excluir o produto'
            ])->setStatusCode(500);
        }
    }
}
