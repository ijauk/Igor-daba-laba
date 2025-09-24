@extends('layouts.app')

@section('content')
    <h1>Hiring Plans</h1>
    <a href="{{ route('hiring-plans.create') }}" class="btn btn-primary">Create New Hiring Plan</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Valid From</th>
                <th>Valid To</th>
                <th>Description</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hiringPlans as $hiringPlan)
                <tr>
                    <td>{{ $hiringPlan->id }}</td>
                    <td>{{ $hiringPlan->valid_from }}</td>
                    <td>{{ $hiringPlan->valid_to }}</td>
                    <td>{{ $hiringPlan->description }}</td>
                    <td>{{ $hiringPlan->active ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('hiring-plans.edit', $hiringPlan->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('hiring-plans.destroy', $hiringPlan->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection