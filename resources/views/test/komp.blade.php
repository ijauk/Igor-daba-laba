@extends('layouts.app')
@section('content')
    <h1>Komponenta sa TomSelect</h1>
    <x-select.tom-select name="job_position_id" id="job_position_id" placeholder="Traži i odaberi poziciju…"
        :endpoint="url('/api/job-positions')" {{-- ili route('api.job-positions') --}} value-field="id" label-field="text"
        search-field="text" :min-input-length="0" :max-options="50" dropdown-parent="body" :selected="old('job_position_id') ?? ($selectedJobPosition->id ?? null)" :options="isset($selectedJobPosition) ? [$selectedJobPosition->id => $selectedJobPosition->name] : []" />
    @error('job_position_id')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
    <div class="my-4"></div>
    <h2>Zaposlenici (više odabira)</h2>
    {{-- više odabira --}}

    <x-select.tom-select name="employee_id" id="employee_id" placeholder="Traži i odaberi zaposlenike…"
        :endpoint="url('/api/employees')" {{-- ili route('api.employees') --}} value-field="id" label-field="text"
        search-field="text" :min-input-length="0" :max-options="50" dropdown-parent="body" :multiple="false"
        :selected="old('employee_id') ?? (isset($selectedEmployees) ? $selectedEmployees->pluck('id')->toArray() : [])"
        :options="isset($selectedEmployees) ? $selectedEmployees->pluck('name', 'id')->toArray() : []" />
    @error('employee_id')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror

@endsection