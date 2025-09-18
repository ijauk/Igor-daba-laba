@extends('layouts.app')
@section('title', 'Popis oglasa - Job Postings')
@section('content')
    <h1>Popis oglasa</h1>
    @if ($job_postings->isEmpty())
        <p>Nema dostupnih oglasa.</p>
    @else
        <div class="list-group">
            @foreach ($job_postings as $job_posting)
                <div class="list-group-item mb-3">
                    <h5 class="mb-1">{{ $job_posting->title }}</h5>
                    <p class="mb-1">{{ $job_posting->description }}</p>
                    <small>Objavljeno: {{ $job_posting->posted_at ? \Carbon\Carbon::parse($job_posting->posted_at)->format('d.m.Y H:i') : 'N/A' }}</small><br>
                    <small>Istek: {{ $job_posting->expires_at ? \Carbon\Carbon::parse($job_posting->expires_at)->format('d.m.Y H:i') : 'N/A' }}</small><br>
                    <small>Rok za prijavu: {{ $job_posting->deadline ? \Carbon\Carbon::parse($job_posting->deadline)->format('d.m.Y H:i') : 'N/A' }}</small><br>
                    <small>Važeći: {{ $job_posting->is_valid ? 'Da' : 'Ne' }}</small>

                    <div class="mt-2">
                        {{-- link na show (pregled) --}}
                        <a href="{{ route('jobpostings.show', $job_posting) }}" class="btn btn-sm btn-info">Pregled</a>

                        {{-- link na edit (uređivanje) --}}
                        <a href="{{ route('jobpostings.edit', $job_posting) }}" class="btn btn-sm btn-secondary">Uredi</a>

                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new TomSelect("#job_position_id", {
                plugins: ['dropdown_input', 'virtual_scroll'],
                valueField: 'id',
                labelField: 'name',
                searchField: 'name', 56
                    maxOptions: 20,
                preload: true,
                load: function (query, callback) {
                    let url = '{{ url('/api/job-positions') }}';
                    if (query.length) {
                        url += '?q=' + encodeURIComponent(query);
                    }
                    fetch(url)
                        .then(response => response.json())
                        .then(json => {
                            callback(json.results);
                        }).catch(() => {
                            callback();
                        });
                },
                render: {
                    option: function (item, escape) {
                        return `<div>${escape(item.name)}</div>`;
                    },
                    item: function (item, escape) {
                        return `<div>${escape(item.name)}</div>`;
                    }
                }
            });
        });
    </script>
@endpush