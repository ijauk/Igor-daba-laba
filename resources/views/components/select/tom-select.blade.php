@php
    $id = $id ?? $name;
    // ako multiple i selected je scalar -> pretvori u array
    $selectedValues = is_array($selected) ? $selected : ($selected !== null ? [$selected] : []);
@endphp

<select id="{{ $id }}" name="{{ $name }}{{ $multiple ? '[]' : '' }}" {{ $multiple ? 'multiple' : '' }}
    class="tomselect w-100" data-endpoint="{{ $endpoint }}" data-placeholder="{{ $placeholder }}"
    data-value-field="{{ $valueField }}" data-label-field="{{ $labelField }}" data-search-field="{{ $searchField }}"
    data-min-input-length="{{ (int) $minInputLength }}" data-max-options="{{ (int) $maxOptions }}"
    data-dropdown-parent="{{ $dropdownParent }}">
    {{-- STATIČKE OPCIJE (ako ih predaš) --}}
    @if($endpoint === null && !empty($options))
        @foreach($options as $val => $label)
            <option value="{{ $val }}" @selected(in_array((string) $val, array_map('strval', $selectedValues)))>
                {{ $label }}
            </option>
        @endforeach
    @endif

    {{-- PRE-SELECTANE OPCIJE U AJAX SCENARIJU (kad znaš labelu unaprijed) --}}
    @if($endpoint !== null && !empty($selectedValues))
        @foreach($selectedValues as $val)
            @php
                // ako si u kontroleru poslao $options za preselect (npr. [id=>label])
                $prelabel = $options[$val] ?? $val;
            @endphp
            <option value="{{ $val }}" selected>{{ $prelabel }}</option>
        @endforeach
    @endif
</select>

@pushOnce('styles')
    <style>
        .ts-dropdown {
            z-index: 2000 !important;
        }
    </style>
@endPushOnce

@pushOnce('scripts')
    {{-- Učitaj TomSelect bundle (pazi putanju) --}}
    {{-- <script src="{{ asset('js/tom-select.complete.min.js') }}"></script> --}}
    <script>
        (function () {
            function initTomSelect(el) {
                if (!window.TomSelect) {
                    console.error('TomSelect nije učitan.');
                    return;
                }
                if (el.tomselect) { try { el.tomselect.destroy(); } catch (e) { } }

                const dataset = el.dataset;
                const endpoint = dataset.endpoint || null;
                const placeholder = dataset.placeholder || 'Traži…';
                const valueField = dataset.valueField || 'id';
                const labelField = dataset.labelField || 'text';
                const searchField = dataset.searchField || 'text';
                const minInput = parseInt(dataset.minInputLength || 0, 10);
                const maxOptions = parseInt(dataset.maxOptions || 50, 10);
                const dropdownParent = dataset.dropdownParent || 'body';

                const config = {
                    valueField, labelField, searchField,
                    create: false,
                    hideSelected: true,
                    maxOptions,
                    openOnFocus: true,
                    closeAfterSelect: !el.multiple, // ako je multiple, ostavi otvoreno
                    preload: endpoint ? 'focus' : null,
                    dropdownParent,
                    placeholder,
                    render: {
                        no_results: function () { return '<div class="no-results py-2 px-3 text-muted">Nema rezultata</div>'; }
                    }
                };

                // Ako je AJAX način (endpoint != null)
                if (endpoint) {
                    let paging = { query: '', page: 1, more: false, loadingMore: false };

                    function makeUrl(base, q, page) {
                        // dozvoli full URL ili path
                        try {
                            const u = new URL(base, window.location.origin);
                            if (q && q.length) u.searchParams.set('q', q);
                            if (page) u.searchParams.set('page', String(page));
                            return u.pathname + u.search;
                        } catch (e) {
                            // ako je base npr. '/api/...'
                            const u = new URL(window.location.origin + base);
                            if (q && q.length) u.searchParams.set('q', q);
                            if (page) u.searchParams.set('page', String(page));
                            return u.pathname + u.search;
                        }
                    }

                    config.load = function (query, callback) {
                        if (minInput > 0 && (!query || query.length < minInput)) {
                            return callback([]);
                        }
                        if (query !== paging.query) {
                            paging = { query: query || '', page: 1, more: false, loadingMore: false };
                        }
                        const url = makeUrl(endpoint, paging.query, 1);
                        fetch(url, { headers: { 'Accept': 'application/json' } })
                            .then(r => r.ok ? r.json() : Promise.reject(r))
                            .then(json => {
                                // očekuješ {results:[{id,text}], pagination:{more:bool}} — prilagodi po potrebi
                                const items = Array.isArray(json?.results) ? json.results : (Array.isArray(json?.data) ? json.data : []);
                                paging.more = !!(json && json.pagination && json.pagination.more);
                                callback(items);
                            })
                            .catch(() => callback());
                    };

                    const ts = new TomSelect(el, config);

                    const dropdownEl = ts.dropdown_content;
                    function loadMore() {
                        if (!paging.more || paging.loadingMore) return;
                        const nearBottom = dropdownEl.scrollTop + dropdownEl.clientHeight >= dropdownEl.scrollHeight - 10;
                        if (!nearBottom) return;

                        paging.loadingMore = true;
                        const nextPage = paging.page + 1;
                        const url = makeUrl(endpoint, paging.query, nextPage);

                        fetch(url, { headers: { 'Accept': 'application/json' } })
                            .then(r => r.ok ? r.json() : Promise.reject(r))
                            .then(json => {
                                const items = Array.isArray(json?.results) ? json.results : (Array.isArray(json?.data) ? json.data : []);
                                if (items.length) {
                                    ts.addOptions(items);
                                    ts.refreshOptions(false);
                                    paging.page = nextPage;
                                }
                                paging.more = !!(json && json.pagination && json.pagination.more);
                            })
                            .finally(() => { paging.loadingMore = false; });
                    }

                    ts.on('dropdown_open', () => {
                        dropdownEl.scrollTop = 0;
                        dropdownEl.removeEventListener('scroll', loadMore);
                        dropdownEl.addEventListener('scroll', loadMore);
                    });

                    ts.on('type', (str) => {
                        if (str !== paging.query) {
                            paging.query = str || '';
                            paging.page = 1;
                            paging.more = false;
                        }
                    });

                    window['ts_' + (el.id || el.name)] = ts; // debug hook
                    return;
                }

                // STATIČKI NAČIN (bez endpointa)
                const ts = new TomSelect(el, config);
                window['ts_' + (el.id || el.name)] = ts;
            }

            function boot() {
                document.querySelectorAll('select.tomselect').forEach(initTomSelect);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', boot, { once: true });
            } else {
                boot();
            }
        })();
    </script>
@endPushOnce