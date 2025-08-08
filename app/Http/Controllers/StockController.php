<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStock;
use App\Http\Requests\UpdateStock;
use App\Models\Stock;

class StockController extends Controller
{
    private function validateStock($id)
    {
        abort(Response()->json([
            'message' => 'Não há nenhum item no estoque com ID ' . $id
        ])->setStatusCode(404));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itens = Stock::all();

        if (!$itens) {
            return Response()->json([
                'message' => 'Nenhum item cadastrado'
            ])->setStatusCode(404);
        }

        return Response()->json($itens)->setStatusCode(200);
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
    public function store(StoreStock $request)
    {
        Stock::create([
            'name' => $request->name,
            'available' => $request->available
        ]);

        return Response()->json([
            'message' => $request->name . ' cadastrado com sucesso',
        ])->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Stock::find($id);

        if (!$item) {
            $this->validateStock($id);
        }

        return Response()->json($item)->setStatusCode(200);
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
    public function update(UpdateStock $request, string $id)
    {
        $item = Stock::find($id);

        if (!$item) {
            $this->validateStock($id);
        }

        $item->name = $request->name ?? $item->name;
        $item->available = $request->available ?? $item->available;

        $item->save();

        return Response()->json([
            'message' => $item->name . ' atualizado com sucesso',
        ])->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Stock::find($id);

        if (!$item) {
            return Response()->json([
                'message' => 'Não há nenhum item no estoque com ID ' . $id
            ])->setStatusCode(404);
        }

        $item->delete();

        $this->validateStock($id);
    }
}
