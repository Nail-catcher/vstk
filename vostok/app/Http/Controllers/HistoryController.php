<?php

namespace App\Http\Controllers;

use App\Models\LogMagazine;
use App\Models\User;
use Inertia\Inertia;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        /*add a user model to view history*/
        $logs = LogMagazine::latest()->paginate(40);
        
        return Inertia::render('History/Index', [
            'users' => User::all(),
            'logs' => $logs
        ]);
    }
}
