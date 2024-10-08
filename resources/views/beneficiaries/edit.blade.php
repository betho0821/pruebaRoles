@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Beneficiario</h2>

        <form action="{{ route('beneficiaries.update', $beneficiary->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ $beneficiary->name }}" required>
            </div>
            <div class="form-group">
                <label for="colonia">Colonia</label>
                <input type="text" name="colonia" class="form-control" value="{{ $beneficiary->colonia }}" required>
            </div>
            <div class="form-group">
                <label for="calle">Calle</label>
                <input type="text" name="calle" class="form-control" value="{{ $beneficiary->calle }}" required>
            </div>
            <div class="form-group">
                <label for="numero">Número</label>
                <input type="text" name="numero" class="form-control" value="{{ $beneficiary->numero }}" required>
            </div>
            <div class="form-group">
                <label for="responsable">Responsable</label>
                <input type="text" name="responsable" class="form-control" value="{{ $beneficiary->responsable }}"
                    required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ $beneficiary->telefono }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@endsection
