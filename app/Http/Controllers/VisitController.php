<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Beneficiary;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function index()
    {
        $visits = Visit::with('beneficiary')->get();
        return view('visits.index', compact('visits'));
    }

    public function create()
    {
        $beneficiaries = Beneficiary::all();
        return view('visits.create', compact('beneficiaries'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'beneficiary_id' => 'required|exists:beneficiaries,id',
            'observations' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Asignar el user_id del usuario autenticado
        $validatedData['user_id'] = auth()->id();

        Visit::create($validatedData);

        return redirect()->route('visits.index')->with('success', 'Visita registrada exitosamente.');
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Radius of the earth in km
        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c; // Distance in km

        return $distance;
    }
}
