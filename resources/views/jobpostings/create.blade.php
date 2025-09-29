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
        <label for="description" class="form-label">Datum i vrijeme objave</label>

        <x-picker.date-time
            name="posted_at"
            id="posted_at"
            :value="old('posted_at')"
            display-format="dd.MM.yyyy HH:mm"
            format="yyyy-MM-dd HH:mm"
            mode="datetime"
            :keep-open="false" />
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Datum isteka oglasa</label>
        <x-picker.date-time
            name="expires_at"
            id="expires_at"
            :value="old('expires_at')"
            display-format="dd.MM.yyyy"
            format="yyyy-MM-dd"
            mode="date"
            :restrict-past="true"
            link-min-to="posted_at"
            :keep-open="false" />
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Rok prijave (datum i vrijeme)</label>
        <x-picker.date-time
            name="deadLine"
            id="deadLine"
            :value="old('deadLine')"
            display-format="dd.MM.yyyy HH:mm"
            format="yyyy-MM-dd HH:mm"
            mode="datetime"
            link-min-to="posted_at"
            :keep-open="false" />
    </div>
    <div class="mb-3">
        <label for="education_id" class="form-label">Stupanj obrazovanja</label>


        <x-select.tom-select name="education_id" id="education_id" placeholder="Traži i odaberi obrazovni stupanj…"
            :endpoint="url('/api/educations')" value-field="id" label-field="text" search-field="text"
            :min-input-length="0" :max-options="50" dropdown-parent="body" :selected="old('education_id') ?? ($selectedEducationId)" :options="$educationOptions" />
        @error('education_id')
        <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror

    </div>

    <div class="mb-3">
        <label for="job_position_id" class="form-label">Pozicija (referenca)</label>


        <x-select.tom-select name="job_position_id" id="job_position_id" placeholder="Traži i odaberi poziciju…"
            :endpoint="url('/api/job-positions')" value-field="id" label-field="text" search-field="text"
            :min-input-length="0" :max-options="50" dropdown-parent="body" :selected="old('job_position_id') ?? ($selectedJobPositionId)" :options="$jobPositionOptions" />
        @error('job_position_id')
        <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror

    </div>

    <div class="mb-3">
        <label for="employee_id" class="form-label">Zaposlenik (referenca)</label>
        <x-select.tom-select name="employee_id" id="employee_id" placeholder="Traži i odaberi zaposlenike…"
            :endpoint="url('/api/employees')" {{-- ili route('api.employees') --}} value-field="id" label-field="text"
            search-field="text" :min-input-length="0" :max-options="50" dropdown-parent="body" :multiple="false"
            :selected="old('employee_id') ?? $selectedEmployeeId" :options="$employeeOptions" />
        @error('employee_id')

        <div class="text-danger small mt-1">{{ $message }} </div>

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
    //$(function () {
    //const $el = $('#job_position_id');

    // $el.select2({
    //     theme: 'bootstrap-5',
    //     width: '100%',
    //     language: 'hr',
    //     placeholder: 'Traži i odaberi poziciju…',
    //     allowClear: true,
    //     minimumInputLength: 0,   // prikaži i bez tipkanja (preporučujem 1 ako želiš)
    //     ajax: {
    //         url: '{{ url('/api/job-positions') }}',
    //         dataType: 'json',
    //         delay: 250,
    //         cache: true,
    //         data: function (params) {
    //             return {
    //                 q: params.term || '',
    //                 page: params.page || 1
    //             };
    //         },
    //         processResults: function (data, params) {
    //             params.page = params.page || 1;
    //             return {
    //                 results: data.results,                    // [{id,text},...]
    //                 pagination: { more: !!data.pagination?.more }
    //             };
    //         }
    //     }
    // });

    // // (Opcionalno) Ako želiš da otvaranje bez tipkanja odmah prikaže 1. stranicu:
    // $el.on('select2:opening', function () {
    //     if (!$el.data('select2').$results.find('li').length) {
    //         $el.select2('open'); // trik koji triggera initial fetch
    //     }
    // });

    // Employee Select2
    //    const $emp = $('#employee_id');
    //     $emp.select2({
    //         theme: 'bootstrap-5',
    //         width: '100%',
    //         language: 'hr',
    //         placeholder: 'Traži zaposlenika…',
    //         allowClear: true,
    //         minimumInputLength: 0,
    //         ajax: {
    //             url: '{{ url('/api/employees') }}',
    //             dataType: 'json',
    //             delay: 250,
    //             cache: true,
    //             data: function (params) {
    //                 return { q: params.term || '', page: params.page || 1 };
    //             },
    //             processResults: function (data, params) {
    //                 params.page = params.page || 1;
    //                 return {
    //                     results: data.results,
    //                     pagination: { more: !!data.pagination?.more }
    //                 };
    //             }
    //         },
    //         // dopušta prikaz emaila u uglatim zagradama bez escape-a
    //         escapeMarkup: function (m) { return m; }
    //     });

    //     // Opcionalno: inicijalni fetch na otvaranje bez tipkanja
    //     $emp.on('select2:opening', function () {
    //         if (!$emp.data('select2').$results.find('li').length) {
    //             $emp.select2('open');
    //         }
    //     });

    // });
</script>
@endpush

<!-- Tempus dominus za datepicker -->
@push('scripts')
<!-- <script>
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
    </script> -->
@endpush