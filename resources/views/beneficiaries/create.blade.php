@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Registro nuevo beneficiario</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('beneficiaries.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="colonia">Colonia</label>
                <input type="text" name="colonia" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="calle">Calle</label>
                <input type="text" name="calle" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="numero">Número</label>
                <input type="text" name="numero" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="responsable">Responsable</label>
                <input type="text" name="responsable" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" class="form-control" required>
            </div>

            <!-- Campos de latitud y longitud ocultos -->
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <button type="submit" id="submit-button" class="btn btn-primary">Registrar</button>
        </form>
    </div>
@endsection

<!-- Script para obtener la ubicación automáticamente -->
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
