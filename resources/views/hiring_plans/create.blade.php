@extends('layouts.app')
@section('title', 'Kreiraj plan zapošljavanja')
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

    <form action="{{ route('hiring-plans.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Naziv
            <input type="text" class="form-control" id="title" name="title" >
            </label>
            @error('title')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="valid_from" class="form-label">Vrijedi od
           <x-picker.date-time
                    name="valid_from"
                    id="valid_from"
                    :value="old('valid_from')"
                    display-format="dd.MM.yyyy"
                    format="yyyy-MM-dd"
                    mode="date"
                    :keep-open="false"/>     
        </label>
        </div>
        <div class="mb-3">
            <label for="valid_to" class="form-label">Vrijedi do
            <x-picker.date-time
                    name="valid_to"
                    id="valid_to"
                    :value="old('valid_to')"
                    display-format="dd.MM.yyyy"
                    format="yyyy-MM-dd"
                    mode="date"
                    :keep-open="false"/>
                    </label>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Opis
            <textarea class="form-control" id="description" name="description" rows="3" ></textarea>
        </label>
        @error('description')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
        </div>
        <div class="mb-3 form-check">
            <input type="hidden" name="active" value="0">
            <input type="checkbox" class="form-check-input" id="active" name="active" value="1" {{ old('active') ? 'checked' : '' }}    >
            <label class="form-check-label" for="active">Aktivan</label>
        </div>
        <button type="submit" class="btn btn-primary">Kreiraj</button>
    </form>
@endsection