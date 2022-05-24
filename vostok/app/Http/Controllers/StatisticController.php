<?php

namespace App\Http\Controllers;

use App\Exports\ApplicationsExport;
use App\Http\Requests\ApplicationFilter;
use App\Models\Application;
use App\Models\Area;
use App\Models\Work;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('Statistics/Index', [
            'works' => Work::all(),
            'areas' => Area::all()
        ]);
    }

    /**
     * @param ApplicationFilter $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function download(ApplicationFilter $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $applications = Application::filter($request->validated());
        return Excel::download(new ApplicationsExport($applications->get()), "statistics-applications.xlsx", \Maatwebsite\Excel\Excel::XLSX);
    }
}
