<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationImport;
use Maatwebsite\Excel\Facades\Excel;

class ApplicationImportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(ApplicationImport $request): \Illuminate\Http\RedirectResponse
    {
        $input = $request->validated();
        Excel::queueImport(new \App\Imports\ApplicationsImport(), $input['file']);
        return redirect()->back();
    }
}
