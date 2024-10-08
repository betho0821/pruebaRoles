@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Registrar Nueva Visita</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Ensure the form has an ID and the hidden inputs are inside the form -->
        <form id="visit-form" action="{{ route('visits.store') }}" method="POST">
            @csrf

            <!-- Hidden fields for latitude and longitude inside the form -->
            <!-- Campos de latitud y longitud ocultos -->
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <div class="form-group">
                <label for="beneficiary_id">Beneficiario</label>
                <select name="beneficiary_id" class="form-control" required>
                    @foreach ($beneficiaries as $beneficiary)
                        <option value="{{ $beneficiary->id }}">{{ $beneficiary->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="observations">Observaciones</label>
                <textarea name="observations" class="form-control"></textarea>
            </div>

            <!-- Add an ID to the submit button -->
            <button id="submit-button" type="submit" class="btn btn-primary">Registrar Visita</button>
        </form>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const submitButton = document.getElementById('submit-button');

        // Desactivar el botón de envío hasta que se obtenga la ubicación
        submitButton.disabled = true;

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                // Asignar las coordenadas obtenidas a los campos ocultos
                latitudeInput.value = position.coords.latitude;
                longitudeInput.value = position.coords.longitude;

                // Habilitar el botón de envío cuando la ubicación esté lista
                submitButton.disabled = false;
            }, function(error) {
                console.error('Error al obtener la ubicación:', error);
                alert('No se pudo obtener la ubicación. Intenta nuevamente.');
            });
        } else {
            alert('Geolocalización no soportada por tu navegador.');
        }
    });
</script>
