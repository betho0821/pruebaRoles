<?php

namespace App\Exports;

use App\Models\Visit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VisitsExport implements FromCollection, WithHeadings
{
    protected $visits;

    public function __construct($visits)
    {
        $this->visits = $visits;
    }

    public function collection()
    {
        // Transformar la colección para incluir los datos que deseas
        return $this->visits->map(function ($visit) {
            return [
                'fecha_visita' => $visit->created_at,
                'nombre_beneficiario' => $visit->beneficiary->name ?? 'N/A', // Asegúrate de manejar si no hay beneficiario
                'agente' => $visit->user->name ?? 'N/A', // Asegúrate de manejar si no hay agente
                'observaciones' => $visit->observations,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Fecha de Visita',
            'Nombre del Beneficiario',
            'Agente',
            'Observaciones',
        ];
    }
}
