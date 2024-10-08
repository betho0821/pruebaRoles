@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Beneficiarios</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('beneficiaries.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-store"></i></a>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Colonia</th>
                    <th>Calle</th>
                    <th>Número</th>
                    <th>Responsable</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($beneficiaries as $beneficiary)
                    <tr>
                        <td>{{ $beneficiary->name }}</td>
                        <td>{{ $beneficiary->colonia }}</td>
                        <td>{{ $beneficiary->calle }}</td>
                        <td>{{ $beneficiary->numero }}</td>
                        <td>{{ $beneficiary->responsable }}</td>
                        <td>{{ $beneficiary->telefono }}</td>
                        <td>
                            <a href="{{ route('beneficiaries.edit', $beneficiary->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection
