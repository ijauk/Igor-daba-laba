@extends('layouts.app')
@section('title', 'Postavi oglas')




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
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
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

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_valid" name="is_valid" value="1">
            <label class="form-check-label" for="is_valid">Oglas je važeći</label>
        </div>
        <button type="submit" class="btn btn-primary">Objavi natječaj</button>
    </form>
@endsection