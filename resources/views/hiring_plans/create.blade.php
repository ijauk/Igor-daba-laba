@extends('layouts.app')
@section('content')
    <h1>Create Hiring Plan</h1>
    <form action="{{ route('hiring-plans.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="valid_from" class="form-label">Valid From
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
            <label for="valid_to" class="form-label">Valid To
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
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="active" name="active">
            <label class="form-check-label" for="active">Active</label>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection