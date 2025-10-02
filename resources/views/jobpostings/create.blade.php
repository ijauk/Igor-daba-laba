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
        <label for="job_position_id" class="form-label">Radno mjesto</label>


        <x-select.tom-select name="job_position_id" id="job_position_id" placeholder="Traži i odaberi poziciju…"
            :endpoint="url('/api/job-positions')" value-field="id" label-field="text" search-field="text"
            :min-input-length="0" :max-options="50" dropdown-parent="body" :selected="old('job_position_id') ?? ($selectedJobPositionId)" :options="$jobPositionOptions" />
        @error('job_position_id')
        <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror

    </div>
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
        @error('description')
        <p style='color: red'>{{$message}}</p>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="posted_at" class="form-label">Datum i vrijeme objave:

                <x-picker.date-time
                    name="posted_at"
                    id="posted_at"
                    :value="old('posted_at')"
                    display-format="dd.MM.yyyy HH:mm"
                    format="yyyy-MM-dd HH:mm"
                    mode="datetime"
                    :keep-open="false" />
            </label>
        </div>


        <div class="col-md-4 mb-3">
            <label for="expires_at" class="form-label">Datum isteka oglasa:
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
            </label>
        </div>



        <div class="col-md-4 mb-3">
            <label for="deadLine" class="form-label">Rok prijave :
                <x-picker.date-time
                    name="deadLine"
                    id="deadLine"
                    :value="old('deadLine')"
                    display-format="dd.MM.yyyy HH:mm"
                    format="yyyy-MM-dd HH:mm"
                    mode="datetime"
                    link-min-to="posted_at"
                    :keep-open="false" />
            </label>
        </div>
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
        <label for="employee_id" class="form-label">Kontakt osoba</label>
        <x-select.tom-select name="employee_id" id="employee_id" placeholder="Traži i odaberi zaposlenike…"
            :endpoint="url('/api/employees')" {{-- ili route('api.employees') --}} value-field="id" label-field="text"
            search-field="text" :min-input-length="0" :max-options="50" dropdown-parent="body" :multiple="false"
            :selected="old('employee_id') ?? $selectedEmployeeId" :options="$employeeOptions" />
        @error('employee_id')

        <div class="text-danger small mt-1">{{ $message }} </div>

        @enderror
    </div>

    <div class="mb-3 form-check">
        <input type="hidden" name="is_valid" value="0">
        <input type="checkbox" class="form-check-input" id="is_valid" name="is_valid" value="1">
        <label class="form-check-label" for="is_valid">Oglas je važeći</label>
    </div>
    <button type="submit" class="btn btn-primary">Objavi natječaj</button>
</form>
@endsection