<!-- resources/views/visits/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Listado de Visitas</h1>
        <a href="{{ route('visits.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i></a>
        <table class="table">
            <table class="table">
                <thead>
                    <tr>
                        <th>Beneficiario</th>
                        <th>Latitud</th>
                        <th>Longitud</th>
                        <th>Observaciones</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visits as $visit)
                        <tr>
                            <td>{{ $visit->beneficiary->name }}</td>
                            <td>{{ $visit->latitude }}</td>
                            <td>{{ $visit->longitude }}</td>
                            <td>{{ $visit->observations }}</td>
                            <td>{{ $visit->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
@endsection
