@extends('layouts.app')
@section('title', 'Uredi oglas')

@section('content')
    <h1>Uredi oglas</h1>

    <form method="POST" action="{{ url('/jobpostings/update', $jobposting) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Naslov</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $jobposting->title) }}">
            @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Opis</label>
            <textarea class="form-control" id="description" name="description"
                rows="4">{{ old('description', $jobposting->description) }}</textarea>
            @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="posted_at" class="form-label">Datum i vrijeme objave</label>
            <div class="input-group" id="postedAtGroup" data-td-target-input="nearest" data-td-target-toggle="nearest">
                <input id="posted_at" name="posted_at" type="text" class="form-control" data-td-target="#posted_at"
                    value="{{ old('posted_at', $selectedDate) }}" placeholder="dd.mm.yyyy HH:mm">
                <span class="input-group-text" data-td-toggle="datetimepicker" data-td-target="#posted_at">
                                                  <i class="bi bi-calendar-date"></i>
                                              </span>
            </div>
            @error('posted_at') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="expires_at" class="form-label">Datum isteka</label>
            <div class="input-group" id="expiresAtGroup" data-td-target-input="nearest" data-td-target-toggle="nearest">
                <input id="expires_at" name="expires_at" type="text" class="form-control" data-td-target="#expires_at"
                    value="{{ old('expires_at', $selectedExpiresAt) }}" placeholder="dd.mm.yyyy">
                <span class="input-group-text" data-td-toggle="datetimepicker" data-td-target="#expires_at">
                                                  <i class="bi bi-calendar-date"></i>
                                              </span>
            </div>
            @error('expires_at') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="deadLine" class="form-label">Rok za prijavu</label>
            <div class="input-group" id="deadLineGroup" data-td-target-input="nearest" data-td-target-toggle="nearest">
                <input id="deadLine" name="deadLine" type="text" class="form-control" data-td-target="#deadLine"
                    value="{{ old('deadLine', $selectedDeadLine) }}" placeholder="dd.mm.yyyy HH:mm">
                <span class="input-group-text" data-td-toggle="datetimepicker" data-td-target="#deadLine">
                                                  <i class="bi bi-calendar-date"></i>
                                              </span>
            </div>
            @error('deadLine') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="education_id" class="form-label">Obrazovna sprema</label>
            <select class="form-select" id="education_id" name="education_id" required>
                <option value="" disabled {{ old('education_id', $jobposting->education_id) ? '' : 'selected' }}>Odaberite
                    obrazovnu spremu</option>
                @foreach($educations as $education)
                    <option value="{{ $education->id }}" {{ (string) old('education_id', $jobposting->education_id) === (string) $education->id ? 'selected' : '' }}>
                        {{ $education->abbreviation }} - {{ $education->remark }}
                    </option>
                @endforeach
            </select>
            @error('education_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="job_position_id" class="form-label">Pozicija (referenca)</label>
            @php
                // Definiraj labelu za preselect:
                // ako želiš samo naziv pozicije: $jpLabel = $selectedJobPosition?->name ?? '';
                // Ako želiš “bogatiji” label (OU + nazivi), složi ga ovdje:
                $jpLabel = '';
                if ($selectedJobPosition) {
                    $ou = $selectedJobPosition->organizationalUnit ?? null; // ako ima relaciju
                    $jpLabel = trim(collect([
                        $ou?->code,                           // npr. OU3.1.1
                        $selectedJobPosition->name,           // npr. Administrator
                        $ou ? "({$ou->name})" : null          // npr. (Financije)
                    ])->filter()->implode(' '));
                }
            @endphp

            <x-select.tom-select name=" job_position_id" id="job_position_id" placeholder="Traži i odaberi poziciju…"
                :endpoint="url('/api/job-positions')" {{-- tvoj API koji vraća {results:[{id,text}], pagination:{more}} --}}
                value-field="id" label-field="text" search-field="text" :min-input-length="0" :max-options="50"
                dropdown-parent="body" :selected="$selectedJobPosition?->id" 
                :options="$selectedJobPosition ? [$selectedJobPosition->id => $selectedJobPosition->label] : []" />

            @error('job_position_id')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="employee_id" class="form-label">Zaposlenik (referenca)</label>
        <x-select.tom-select name="employee_id" id="employee_id" placeholder="Traži i odaberi zaposlenike…"
            :endpoint="url('/api/employees')" {{-- ili route('api.employees') --}} value-field="id" label-field="text"
            search-field="text" :min-input-length="0" :max-options="50" dropdown-parent="body" :multiple="false"
            :selected="old('employee_id') ?? (isset($selectedEmployees) ? $selectedEmployees->pluck('id')->toArray() : [])"
            :options="isset($selectedEmployees) ? $selectedEmployees->pluck('name', 'id')->toArray() : []" />
        @error('employee_id')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_valid" name="is_valid" value="1" {{ old('is_valid', $jobposting->is_valid) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_valid">Oglas je važeći</label>
        </div>

        <button type="submit" class="btn btn-primary">Spremi izmjene</button>
        <a href="{{ route('jobpostings.index') }}" class="btn btn-secondary ms-2">Natrag</a>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tempus Dominus pickeri
            const postedAt = new tempusDominus.TempusDominus(document.getElementById('postedAtGroup'), {
                localization: { locale: 'hr', startOfTheWeek: 1, format: 'dd.MM.yyyy HH:mm' },
                display: { components: { calendar: true, clock: true, hours: true, minutes: true, seconds: false } },
                useCurrent: false
            });

            const expiresAt = new tempusDominus.TempusDominus(document.getElementById('expiresAtGroup'), {
                localization: { locale: 'hr', startOfTheWeek: 1, format: 'dd.MM.yyyy' },
                display: { components: { calendar: true, clock: false } },
                restrictions: { minDate: new Date() },
                useCurrent: false
            });

            const deadLine = new tempusDominus.TempusDominus(document.getElementById('deadLineGroup'), {
                localization: { locale: 'hr', startOfTheWeek: 1, format: 'dd.MM.yyyy HH:mm' },
                display: { components: { calendar: true, clock: true, hours: true, minutes: true, seconds: false } },
                useCurrent: false
            });

            // Veži minimalne datume uz posted_at
            document.getElementById('postedAtGroup').addEventListener('change.td', (e) => {
                const d = e.detail.date || null;
                if (d) {
                    deadLine.updateOptions({ restrictions: { minDate: d } });
                    expiresAt.updateOptions({ restrictions: { minDate: d } });
                }
            });
        });
    </script>
@endpush