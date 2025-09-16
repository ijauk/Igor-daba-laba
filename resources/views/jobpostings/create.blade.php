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
            <input type="datetime-local" class="form-control" name="posted_at" id="posted_at">
        </div>
        <div class="mb-3">
            <label for="expires_at" class="form-label">Datum i vrijeme isteka</label>
            <input type="datetime-local" class="form-control" name="expires_at" id="expires_at">
        </div>
        <div class="mb-3">
            <label for="deadLine" class="form-label">Rok za prijavu</label>
            <input type="datetime-local" class="form-control" name="deadLine" id="deadLine">
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
            <select id="job_position_id" name="job_position_id" placeholder="Traži i odaberi poziciju…"></select>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_valid" name="is_valid" value="1">
            <label class="form-check-label" for="is_valid">Oglas je važeći</label>
        </div>
        <button type="submit" class="btn btn-primary">Objavi natječaj</button>
    </form>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const url = '{{ url('/api/job-positions') }}';

            new TomSelect('#job_position_id', {
                valueField: 'id',
                labelField: 'text',
                searchField: 'text',

                // VAŽNO: prikaži dropdown i rezultate odmah na fokus,
                // tako se vidi da plugin radi (input unutar dropdowna)
                openOnFocus: true,
                preload: 'focus',          // load('') na focus → dobijemo 1. stranicu bez upita



                shouldLoad: function (query) {
                    return query.length > 0;
                },

                load: function (query, callback) {
                    let page = this._page || 1;

                    fetch(`${url}?q=${encodeURIComponent(query)}&page=${page}`)
                        .then(response => response.json())
                        .then(json => {
                            this._page = json.pagination.more ? page + 1 : 1;
                            callback(json.results);
                        })
                        .catch(() => callback());
                },

                onType: function (str) {
                    this._page = 1;
                }
            });
        });
    </script>
@endpush