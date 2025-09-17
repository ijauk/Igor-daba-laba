@extends('layouts.app')
@section('title', 'Postavi oglas')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@section('content')
    <h1>Postavite oglas</h1>
    <form method="POST" action="{{ route('jobpostings.store') }}">
        @csrf
        <div class="mb-3">
            <label>Naslov: <br>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            </label>
            @error('title')
                <p style='color: red'>{{$message}}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Opis</label>
            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
        </div>
        <div class="mb-3">
            <label for="posted_at" class="form-label">Datum i vrijeme objave</label>
            <div class="input-group" id="postedAtGroup" data-td-target-input="nearest" data-td-target-toggle="nearest">
                <input id="posted_at" name="posted_at" type="text" class="form-control" data-td-target="#posted_at"
                    value="{{ old('posted_at') }}" placeholder="Odaberi datum i vrijeme" />
                <span class="input-group-text" data-td-toggle="datetimepicker" data-td-target="#posted_at">
                                  <i class="bi bi-calendar-date"></i>
                                </span>
            </div>
        </div>

        <div class="mb-3">
            <label for="expires_at" class="form-label">Datum isteka</label>
            <div class="input-group" id="expiresAtGroup" data-td-target-input="nearest" data-td-target-toggle="nearest">
                <input id="expires_at" name="expires_at" type="text" class="form-control" data-td-target="#expires_at"
                    value="{{ old('expires_at') }}" placeholder="Odaberi datum" />
                <span class="input-group-text" data-td-toggle="datetimepicker" data-td-target="#expires_at">
                                  <i class="bi bi-calendar-date"></i>
                                </span>
            </div>
        </div>

        <div class="mb-3">
            <label for="deadLine" class="form-label">Rok za prijavu</label>
            <div class="input-group" id="deadLineGroup" data-td-target-input="nearest" data-td-target-toggle="nearest">
                <input id="deadLine" name="deadLine" type="text" class="form-control" data-td-target="#deadLine"
                    value="{{ old('deadLine') }}" placeholder="Odaberi datum i vrijeme" />
                <span class="input-group-text" data-td-toggle="datetimepicker" data-td-target="#deadLine">
                                  <i class="bi bi-calendar-date"></i>
                                </span>
            </div>
        </div>
        <div class="mb-3">
            <label for="education_id" class="form-label">Obrazovna sprema</label>
            <select class="form-select" id="education_id" name="education_id">
                <option value="" disabled selected>Odaberite obrazovnu spremu</option>
                @foreach($educations as $education)
                    <option value="{{ $education->id }}">{{ $education->abbreviation }} - {{ $education->remark }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="job_position_id" class="form-label">Pozicija</label>
            <select id="job_position_id" class="form-select" name="job_position_id" placeholder="Traži i odaberi poziciju…">
                @if(old('job_position_id') && $selectedJobPosition)
                    <option value="{{ old('job_position_id') }}" selected>
                        {{ $selectedJobPosition->name }}
                    </option>
                @endif
            </select>

        </div>

        <div class="mb-3">
            <label for="employee_id" class="form-label">Zaposlenik (referenca)</label>
            <select id="employee_id" class="form-select" name="employee_id" placeholder="Traži zaposlenika…">
                @if(old('employee_id') && !empty($selectedEmployee))
                    <option value="{{ old('employee_id') }}" selected>
                        {{ $selectedEmployee->last_name }} {{ $selectedEmployee->first_name }}@if($selectedEmployee->email)
                        &lt;{{ $selectedEmployee->email }}&gt;@endif
                    </option>
                @endif
            </select>
            @error('employee_id')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_valid" name="is_valid" value="1">
            <label class="form-check-label" for="is_valid">Oglas je važeći</label>
        </div>
        <button type="submit" class="btn btn-primary">Objavi natječaj</button>
    </form>
@endsection

<!-- Select2 jer ne uspijevam podesiti tom-select -->
@push('scripts')
    <script>
        $(function () {
            const $el = $('#job_position_id');

            $el.select2({
                theme: 'bootstrap-5',
                width: '100%',
                language: 'hr',
                placeholder: 'Traži i odaberi poziciju…',
                allowClear: true,
                minimumInputLength: 0,   // prikaži i bez tipkanja (preporučujem 1 ako želiš)
                ajax: {
                    url: '{{ url('/api/job-positions') }}',
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    data: function (params) {
                        return {
                            q: params.term || '',
                            page: params.page || 1
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.results,                    // [{id,text},...]
                            pagination: { more: !!data.pagination?.more }
                        };
                    }
                }
            });

            // (Opcionalno) Ako želiš da otvaranje bez tipkanja odmah prikaže 1. stranicu:
            $el.on('select2:opening', function () {
                if (!$el.data('select2').$results.find('li').length) {
                    $el.select2('open'); // trik koji triggera initial fetch
                }
            });

            // Employee Select2
            const $emp = $('#employee_id');
            $emp.select2({
                theme: 'bootstrap-5',
                width: '100%',
                language: 'hr',
                placeholder: 'Traži zaposlenika…',
                allowClear: true,
                minimumInputLength: 0,
                ajax: {
                    url: '{{ url('/api/employees') }}',
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    data: function (params) {
                        return { q: params.term || '', page: params.page || 1 };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.results,
                            pagination: { more: !!data.pagination?.more }
                        };
                    }
                },
                // dopušta prikaz emaila u uglatim zagradama bez escape-a
                escapeMarkup: function (m) { return m; }
            });

            // Opcionalno: inicijalni fetch na otvaranje bez tipkanja
            $emp.on('select2:opening', function () {
                if (!$emp.data('select2').$results.find('li').length) {
                    $emp.select2('open');
                }
            });

        });
    </script>
@endpush

<!-- Tempus dominus za datepicker -->
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // posted_at → datetime
            const postedAt = new tempusDominus.TempusDominus(document.getElementById('postedAtGroup'), {
                localization: { locale: 'hr', startOfTheWeek: 1, format: 'dd.MM.yyyy HH:mm' },
                display: { components: { calendar: true, clock: true, hours: true, minutes: true, seconds: false } },
                useCurrent: false
            });

            // expires_at → samo date
            const expiresAt = new tempusDominus.TempusDominus(document.getElementById('expiresAtGroup'), {
                localization: { locale: 'hr', startOfTheWeek: 1, format: 'dd.MM.yyyy' },
                display: { components: { calendar: true, clock: false } },
                restrictions: { minDate: new Date() }, // ne dozvoli prošle datume
                useCurrent: false
            });

            // deadLine → datetime
            const deadLine = new tempusDominus.TempusDominus(document.getElementById('deadLineGroup'), {
                localization: { locale: 'hr', startOfTheWeek: 1, format: 'dd.MM.yyyy HH:mm' },
                display: { components: { calendar: true, clock: true, hours: true, minutes: true } },
                useCurrent: false
            });

            // Logika: deadLine ne smije biti prije posted_at
            document.getElementById('postedAtGroup').addEventListener('change.td', (e) => {
                deadLine.updateOptions({
                    restrictions: { minDate: e.detail.date }
                });
            });

            // Logika: expires_at ne smije biti prije posted_at (po datumu)
            document.getElementById('postedAtGroup').addEventListener('change.td', (e) => {
                if (e.detail.date) {
                    expiresAt.updateOptions({
                        restrictions: { minDate: e.detail.date }
                    });
                }
            });
        });
    </script>
@endpush