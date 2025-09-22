@extends('layouts.app')

@section('content')
    <h1>I kaj sad</h1>
    <p>Okidanje pipeline-a</p>
    @for ($i = 1; $i <= 25; $i++)
        <p>{{ $i }}</p>
    @endfor
@endsection