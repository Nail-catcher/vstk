<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryFilter;
use App\Http\Requests\InventoryStore;
use App\Http\Resources\InventoriesResource;
use App\Http\Resources\InventoryResource;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param InventoryFilter $request
     * @return InventoriesResource
     */
    public function index(InventoryFilter $request): InventoriesResource
    {
        $input = $request->validated();
        $inventories = Inventory::with('category');
        $inventories->filter($input);
        return new InventoriesResource($inventories->paginate()->appends($input));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InventoryStore $request
     * @return InventoryResource
     */
    public function store(InventoryStore $request): InventoryResource
    {
        $input = $request->validated();
        $inventory = new Inventory();
        if ($request->filled('inventory')) {
            $cp = Inventory::find($request->inventory);
            $inventory->fill($cp->toArray());
            $inventory->manufacturer_code = $input['manufacturer_code'];
            $inventory->serial_number = $input['serial_number'];
            $inventory->barcode = $input['barcode'];
            $inventory->barcode_type = $input['barcode_type'];
        } else {
            $inventory->fill($input);
        }
        $inventory->category()->associate($input['category']);
        $inventory->save();
        $inventory->users()->attach($request->user());
        return new InventoryResource($inventory);
    }

    /**
     * Display the specified resource.
     *
     * @param Inventory $inventory
     * @return InventoryResource
     */
    public function show(Inventory $inventory): InventoryResource
    {
        return new InventoryResource($inventory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Inventory $inventory
     * @return void
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Inventory $inventory
     * @return void
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
