@extends('layouts.app')

@section('content')
    <h1>Test Page</h1>
    <div class="mb-3">
        <label for="job_position_id" class="form-label">Pozicija</label>
        <select class="w-100" id="job_position_id" name="job_position_id" placeholder="Traži i odaberi poziciju…">
            @if(old('job_position_id') && isset($selectedJobPosition))
                <option value="{{ old('job_position_id') }}" selected>{{ $selectedJobPosition->name }}</option>
            @endif
        </select>
        @error('job_position_id')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Defensive: ensure TomSelect is available
            if (typeof TomSelect === 'undefined') {
                console.error('TomSelect JS nije učitan. Provjeri <script> include i redoslijed.');
                return;
            }

            const el = document.getElementById('job_position_id');
            if (!el) return;

            // Inicijalizacija s postavkama koje rješavaju probleme s Bootstrap 5 / modalima
            const ts = new TomSelect(el, {
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                maxOptions: 50,
                openOnFocus: true,
                closeAfterSelect: true,
                // ključni fix: dropdown izvan roditelja (izbjegava overflow:hidden i stacking konteks)
                dropdownParent: 'body',
                load: function (query, callback) {
                    if (!query.length) return callback();
                    fetch(`/api/job-positions?q=${encodeURIComponent(query)}`)
                        .then(r => r.json())
                        .then(json => callback(json.data || []))
                        .catch(() => callback());
                }
            });

            // Izloži za brzi debug u konzoli
            window.tsJobPosition = ts;

            // Ako je dropdown možda ispod modala, osiguraj z-index i reflow na focus
            ts.on('focus', () => {
                ts.refreshOptions(false);
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Z-index iznad Bootstrap modala/backdropa; prilagodi po potrebi */
        .ts-dropdown {
            z-index: 2000 !important;
        }
    </style>
@endpush