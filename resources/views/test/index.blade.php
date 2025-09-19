@extends('layouts.app')

@section('content')
    <h1>Test Page</h1>
    <div class="mb-3">
        <label for="job_position_id" class="form-label">Pozicija</label>
        <select class="w-100" id="job_position_id" name="job_position_id" placeholder="Traži i odaberi poziciju…">
            @if(old('job_position_id') && isset($selectedJobPosition))
                <option value="{{ old('job_position_id') }}" selected>{{ $selectedJobPosition->name }}</option>
            @endif
        </select>
        @error('job_position_id')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
@endsection
@pushOnce('scripts')
    <script>
        (function () {
            function initTomSelectJob() {
                const el = document.getElementById('job_position_id');
                if (!el) return;

                // Ako je već inicijaliziran (npr. zbog ponovnog mounta), uništi staru instancu
                if (el.tomselect) {
                    try { el.tomselect.destroy(); } catch (e) { }
                }

                if (typeof TomSelect === 'undefined') {
                    console.error('TomSelect nije učitan. Učitaj tom-select.complete.min.js prije ovog bloka.');
                    return;
                }

                // Paging state (Select2-style)
                let paging = {
                    query: '',
                    page: 1,
                    more: false,
                    loadingMore: false
                };

                function makeUrl(base, q, page) {
                    const u = new URL(base, window.location.origin);
                    if (q && q.length) u.searchParams.set('q', q);
                    if (page) u.searchParams.set('page', String(page));
                    return u.pathname + u.search;
                }

                const ts = new TomSelect(el, {
                    valueField: 'id',
                    labelField: 'text',
                    searchField: 'text',
                    create: false,
                    hideSelected: true,
                    openOnFocus: true,
                    closeAfterSelect: true,
                    dropdownParent: 'body', // izbjegni overflow/stacking probleme u BS5
                    preload: 'focus',       // predučitaj kad dobije fokus
                    shouldLoad: function (query) { return true; }, // dopusti load i bez queryja
                    load: function (query, callback) {
                        const base = '/api/job-positions';
                        // reset paging if query changed
                        if (query !== paging.query) {
                            paging.query = query || '';
                            paging.page = 1;
                            paging.more = false;
                        }
                        const url = makeUrl(base, paging.query, 1);
                        fetch(url)
                            .then(r => r.ok ? r.json() : Promise.reject(r))
                            .then(json => {
                                const items = Array.isArray(json?.results) ? json.results : [];
                                paging.more = !!(json && json.pagination && json.pagination.more);
                                callback(items);
                            })
                            .catch(() => callback());
                    },
                    render: {
                        no_results: function () {
                            return '<div class="no-results py-2 px-3 text-muted">Nema rezultata</div>';
                        }
                    }
                });

                // Open dropdown when focusing and wire up infinite scroll
                const dropdownEl = ts.dropdown_content;

                function loadMoreIfNeeded() {
                    if (!paging.more || paging.loadingMore) return;
                    const nearBottom = dropdownEl.scrollTop + dropdownEl.clientHeight >= dropdownEl.scrollHeight - 10;
                    if (!nearBottom) return;
                    paging.loadingMore = true;
                    const nextPage = paging.page + 1;
                    const base = '/api/job-positions';
                    const nextUrl = makeUrl(base, paging.query, nextPage);
                    fetch(nextUrl)
                        .then(r => r.ok ? r.json() : Promise.reject(r))
                        .then(json => {
                            const items = Array.isArray(json?.results) ? json.results : [];
                            if (items.length) {
                                ts.addOptions(items);
                                ts.refreshOptions(false);
                            }
                            paging.more = !!(json && json.pagination && json.pagination.more);
                            if (items.length) paging.page = nextPage;
                        })
                        .finally(() => { paging.loadingMore = false; });
                }

                // Rebind scroll each time dropdown opens
                ts.on('dropdown_open', () => {
                    // reset scroll
                    dropdownEl.scrollTop = 0;
                    dropdownEl.removeEventListener('scroll', loadMoreIfNeeded);
                    dropdownEl.addEventListener('scroll', loadMoreIfNeeded);
                });

                // Keep paging in sync with search typing
                ts.on('type', (str) => {
                    // if query changes, reset page so the next load() starts from page 1
                    if (str !== paging.query) {
                        paging.query = str || '';
                        paging.page = 1;
                        paging.more = false;
                    }
                });

                // Izloži za debug
                window.tsJobPosition = ts;
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initTomSelectJob, { once: true });
            } else {
                initTomSelectJob();
            }
        })();
    </script>
@endPushOnce



@pushOnce('styles')
    <style>
        /* Z-index iznad Bootstrap modala/backdropa; prilagodi po potrebi */
        .ts-dropdown {
            z-index: 2000 !important;
        }
    </style>
@endPushOnce