<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryFilter;
use App\Models\Division;
use App\Models\InventoryUser;
use App\Models\User;
use Inertia\Inertia;

class InventoryHistoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function __invoke(InventoryFilter $request): \Inertia\Response
    {
        $history = InventoryUser::with(['user', 'user.division'])
            ->select(['user_id'])
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at, COUNT(inventory_id) as count")
            ->groupBy('user_id')
            ->groupByRaw("DATE_FORMAT(created_at, '%Y-%m-%d')");
        $history->filter($request->validated());
        return Inertia::render('Inventories/History', [
            'history' => $history->get(),
            'users' => User::orderBy('lastname')->get(),
            'divisions' => Division::all(),
        ]);
    }
}
