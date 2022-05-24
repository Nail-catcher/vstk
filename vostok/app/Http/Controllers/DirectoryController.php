<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('Directory/Index', []);
    }

    public function auto(): \Inertia\Response
    {
        return Inertia::render('Directory/Auto', []);
    }

    public function material(): \Inertia\Response
    {
        return Inertia::render('Directory/Material', []);
    }

    public function keys(): \Inertia\Response
    {
        return Inertia::render('Directory/Keys', []);
    }
}
