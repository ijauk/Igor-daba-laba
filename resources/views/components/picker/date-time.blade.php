@php

    $id = $id ?? $name;
@endphp

<div class="td-wrapper w-100" data-dropdown-parent="{{ $dropdownParent }}">
    <div class="input-group" id="grp-{{ $id }}" data-td-target-input="nearest" data-td-target-toggle="nearest">
        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="text"
            class="form-control td-input"
            placeholder="{{ $placeholder }}"
            value="{{ old($name, $value) }}"
            data-format="{{ $format }}"
            data-display-format="{{ $displayFormat }}"
            data-side-by-side="{{ $sideBySide ? 'true' : 'false' }}"
            data-stepping="{{ (int) $stepping }}"
            data-min-date="{{ $minDate }}"
            data-max-date="{{ $maxDate }}"
            data-use-seconds="{{ $useSeconds ? 'true' : 'false' }}"
            data-use-24-hours="{{ $use24Hours ? 'true' : 'false' }}"
            data-keep-open="{{ $keepOpen ? 'true' : 'false' }}"
            data-buttons-today="{{ $buttonsToday ? 'true' : 'false' }}"
            data-buttons-clear="{{ $buttonsClear ? 'true' : 'false' }}"
            data-buttons-close="{{ $buttonsClose ? 'true' : 'false' }}"
            autocomplete="{{ $autocomplete }}"
            {{ $readonly ? 'readonly' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $required ? 'required' : '' }}
        />
        <span class="input-group-text" data-td-toggle="datetimepicker" data-td-target="#{{ $id }}">
            <i class="bi bi-calendar-event"></i>
        </span>
    </div>
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

@pushOnce('styles')
<style>
/* osiguraj da overlay probije modal / dropdown stacking */
.tempus-dominus-widget {
    z-index: 2000 !important;
}
</style>
@endPushOnce

@pushOnce('scripts')
<script>
(function () {
    function initTd(input) {
        if (!window.tempusDominus) {
            console.error('Tempus Dominus nije učitan.');
            return;
        }

        const ds = input.dataset;

        const opts = {
            localization: {
                locale: 'hr',             // hr-HR locale (učitaj prije ako koristiš lokalizaciju iz njihovog paketa)
                startOfTheWeek: 1,        // ponedjeljak
            },
            display: {
                components: {
                    calendar: true,
                    date: true,
                    month: true,
                    year: true,
                    decades: true,
                    clock: true,
                    hours: true,
                    minutes: true,
                    seconds: (ds.useSeconds === 'true'),
                },
                sideBySide: (ds.sideBySide === 'true'),
                buttons: {
                    today: (ds.buttonsToday === 'true'),
                    clear: (ds.buttonsClear === 'true'),
                    close: (ds.buttonsClose === 'true'),
                },
                theme: 'auto',
                // format prikaza u inputu
                // Napomena: v6 koristi Intl/Formatter, patterni su približno kao u docs; prilagodi po potrebi
                keepOpen: (ds.keepOpen === 'true'),
            },
            stepping: parseInt(ds.stepping || '5', 10),
            useCurrent: false,
        };

        // format zapisa u inputu – možeš i custom formatter ako koristiš Luxon/Day.js
        const displayFormat = ds.displayFormat || ds.format || 'yyyy-MM-dd HH:mm';

        // Min/Max
        if (ds.minDate) opts.restrictions = Object.assign({}, opts.restrictions, { minDate: new Date(ds.minDate) });
        if (ds.maxDate) opts.restrictions = Object.assign({}, opts.restrictions, { maxDate: new Date(ds.maxDate) });

        // 24h sat
        if (ds.use24Hours === 'true') {
            opts.localization = Object.assign({}, opts.localization, { hourCycle: 'h23' });
        }

        // Init
        const picker = new tempusDominus.TempusDominus(input, Object.assign({}, opts, {
            display: Object.assign({}, opts.display, {
                // TD v6 koristi `display.components` + `localization` + `format`
                // Ako želiš striktno zadati format:
                // format: displayFormat
                // Ako želiš prepustiti locale formatteru, izostavi line iznad.
                // U praksi – često je dovoljno samo `format: displayFormat`.
                format: displayFormat
            })
        }));

        // Prethodno postavljena vrijednost (ako postoji)
        if (input.value) {
            try { picker.dates.setValue(new Date(input.value)); } catch (e) {}
        }

        // Event – ažuriraj input on change
        input.addEventListener('change.td', (ev) => {
            // ev.target.value već sadrži string po formatu
            // Ako trebaš dodatni hidden input s ISO zapisom, ovdje ga možeš postaviti.
        });

        // Debug hook
        window['td_' + (input.id || input.name)] = picker;
    }

    function boot() {
        document.querySelectorAll('input.td-input, .td-wrapper input.td-input').forEach(initTd);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot, { once: true });
    } else {
        boot();
    }
})();
</script>
@endPushOnce