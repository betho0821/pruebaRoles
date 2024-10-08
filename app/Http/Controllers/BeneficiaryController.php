<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beneficiary;

class BeneficiaryController extends Controller
{
    // Solo Agents pueden acceder a estas rutas
    public function __construct()
    {
        $this->middleware('role:Agent');
    }
    // Mostrar lista de beneficiarios
    public function index()
    {
        $beneficiaries = Beneficiary::all();
        return view('beneficiaries.index', compact('beneficiaries'));
    }
    // Mostrar formulario de creación
    public function create()
    {
        return view('beneficiaries.create');
    }

    // Guardar un nuevo beneficiario
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'colonia' => 'required|string|max:255',
            'calle' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        Beneficiary::create($validatedData);

        return redirect()->route('beneficiaries.index')->with('success', 'Beneficiario registrado exitosamente.');
    }


    public function edit($id)
    {
        $beneficiary = Beneficiary::findOrFail($id); // Find the beneficiary by ID
        return view('beneficiaries.edit', compact('beneficiary'));
    }

    // Update a specific beneficiary's data
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'colonia' => 'required|string|max:255',
            'calle' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
        ]);

        $beneficiary = Beneficiary::findOrFail($id); // Find the beneficiary by ID
        $beneficiary->update($validatedData); // Update beneficiary with validated data

        return redirect()->route('beneficiaries.index')->with('success', 'Beneficiario actualizado exitosamente.');
    }
}
