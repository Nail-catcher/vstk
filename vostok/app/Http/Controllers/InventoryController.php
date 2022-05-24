<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryFilter;
use App\Http\Resources\InventoriesResource;
use App\Models\Category;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param InventoryFilter $request
     * @return \Inertia\Response
     */
    public function index(InventoryFilter $request): \Inertia\Response
    {
        $input = $request->validated();
        $inventories = Inventory::with('category')->filter($input);
        return Inertia::render('Inventories/Index', [
            'inventories' => new InventoriesResource($inventories->paginate()->appends($input)),
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Inventory $inventory
     * @return \Inertia\Response
     */
    public function show(Inventory $inventory): \Inertia\Response
    {
        return Inertia::render('Inventories/Show', [
            'inventory' => $inventory
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Inventory $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Inventory $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Inventory $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
