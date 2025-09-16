<div x-data="{ isOpen: false }" class="position-relative">
    <div wire:loading.class.remove="d-none" class="position-absolute top-0 end-0 d-none small text-muted">
        Učitavam…
    </div>
    <label class="form-label">Pozicija</label>

    {{-- Prikaz trenutno odabranog + hidden input za submit --}}
    @if($selectedId)
        <div class="d-flex gap-2 align-items-center mb-2">
            <div class="form-control bg-light">{{ $selectedLabel }}</div>
            <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="clear">Ukloni</button>
        </div>
        <input type="hidden" name="job_position_id" value="{{ $selectedId }}">
    @endif

    {{-- Polje za pretraživanje / odabir (otvara listu) --}}
    {{-- Polje za pretraživanje / odabir (otvara listu) --}}
    @if(!$selectedId)
        <input type="text" class="form-control" placeholder="Traži poziciju..." wire:model.live.debounce.300ms="search"
            @focus="isOpen = true" @keydown.escape.window="isOpen = false" @click.away="isOpen = false">
    @endif
    <div x-show="isOpen" x-transition class="border rounded mt-1 bg-white shadow-sm"
        style="position:absolute; z-index: 50; width:100%; max-height: 260px; overflow:auto;">
        @forelse($results as $item)
            <button type="button" class="w-100 text-start px-3 py-2 border-0 bg-white hover" style="cursor:pointer"
                x-on:click="isOpen = false" wire:click="select({{ $item->id }})">
                {{ $item->name }}
            </button>
        @empty
            <div class="px-3 py-2 text-muted">Nema rezultata.</div>
        @endforelse

        {{-- Paginacija unutar dropdowna (server-side) --}}
        @if($results->hasPages())
            <div class="d-flex justify-content-between align-items-center border-top px-2 py-1">
                <button type="button" class="btn btn-sm btn-light" wire:click="previousPage"
                    @click="$nextTick(() => isOpen = true)" @disabled(!$results->previousPageUrl())>«</button>

                <span class="small">Stranica {{ $results->currentPage() }} / {{ $results->lastPage() }}</span>

                <button type="button" class="btn btn-sm btn-light" wire:click="nextPage"
                    @click="$nextTick(() => isOpen = true)" @disabled(!$results->nextPageUrl())>»</button>
            </div>
        @endif
    </div>

    {{-- Error prikaz (ako ga u formi validiraš) --}}
    @error('job_position_id')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>