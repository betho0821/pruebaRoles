<?php

// app/Http/Controllers/ReportController.php
namespace App\Http\Controllers;

use App\Exports\VisitsExport;
use Illuminate\Http\Request;
use App\Models\Visit;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index'); // Asegúrate de que esta vista exista
    }
    public function filter(Request $request)
    {
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Obtener las visitas dentro del rango de fechas
        $visits = Visit::with(['beneficiary', 'user']) // Cargar relaciones
            ->whereBetween('created_at', [
                $validatedData['start_date'] . ' 00:00:00',
                $validatedData['end_date'] . ' 23:59:59'
            ])
            ->get();

        // Mostrar la vista con las visitas filtradas
        return view('reports.index', compact('visits'));
    }

    public function export(Request $request)
    {
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Obtener las visitas dentro del rango de fechas
        $visits = Visit::with(['beneficiary', 'user'])
            ->whereBetween('created_at', [
                $validatedData['start_date'] . ' 00:00:00',
                $validatedData['end_date'] . ' 23:59:59'
            ])
            ->get();

        // Generar y descargar el Excel
        return Excel::download(new VisitsExport($visits), 'visitas.xlsx');
    }
}
