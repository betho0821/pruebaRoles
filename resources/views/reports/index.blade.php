@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Reportes de Visitas</h1>

        <!-- Formulario de filtrado por fecha -->
        <form id="filter-form" action="{{ route('reports.filter') }}" method="GET">
            <div class="form-group">
                <label for="start_date">Fecha Inicio</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" required>
            </div>
            <div class="form-group">
                <label for="end_date">Fecha Fin</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="submitFilterForm()">Generar Reporte</button>
        </form>

        <!-- Formulario para generar Excel -->
        <form id="excel-form" action="{{ route('reports.export') }}" method="GET">
            <input type="hidden" name="start_date" id="excel_start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" id="excel_end_date" value="{{ request('end_date') }}">
            <button type="button" class="btn btn-success mt-3" onclick="submitExcelForm()">Generar Excel</button>
        </form>

        <!-- Mapa para mostrar las visitas -->
        <div id="map" style="height: 500px; width: 100%; margin-top: 20px;"></div>
    </div>

    <!-- Incluimos el script de Leaflet para el mapa -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    <script>
        // Función para enviar el formulario de filtro de reporte
        function submitFilterForm() {
            document.getElementById('filter-form').submit();
        }

        // Función para enviar el formulario de generación de Excel
        function submitExcelForm() {
            document.getElementById('excel-form').submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            var visits = @json($visits ?? []);

            if (visits.length > 0) {
                var firstVisit = visits[0];
                var map = L.map('map').setView([firstVisit.latitude, firstVisit.longitude], 12);
            } else {
                var map = L.map('map').setView([19.432608, -99.133209], 12); // Ciudad de México
            }

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
            }).addTo(map);

            visits.forEach(function(visit) {
                L.marker([visit.latitude, visit.longitude])
                    .bindPopup(
                        `Beneficiario: ${visit.beneficiary.name}<br>Observaciones: ${visit.observations}`)
                    .addTo(map);
            });
        });
    </script>
@endsection
