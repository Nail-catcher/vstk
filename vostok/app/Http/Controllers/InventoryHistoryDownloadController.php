<?php

namespace App\Http\Controllers;

use App\Exports\InventoryUser;
use App\Http\Requests\InventoryFilter;
use Maatwebsite\Excel\Facades\Excel;

class InventoryHistoryDownloadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param InventoryFilter $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function __invoke(InventoryFilter $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $input = $request->validated();
        $date = now()->format('Y-m-d');
        $history = \App\Models\InventoryUser::with(['user', 'inventory']);
        $history->filter($input);
        return Excel::download(new InventoryUser($history->get()->toBase(), $input['date_from'], $input['date_to']), "inventory-{$date}.xlsx", \Maatwebsite\Excel\Excel::XLSX);
    }
}
