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
            data-mode="{{ $mode }}"
            data-restrict-past="{{ $restrictPast ? 'true' : 'false' }}"
            data-link-min="{{ $linkMinTo }}"
            data-link-max="{{ $linkMaxTo }}"
            data-use-bootstrap-icons="{{ $useBootstrapIcons ? 'true' : 'false' }}"
            {{ $readonly ? 'readonly' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $required ? 'required' : '' }} />
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
    (function() {
        function initTd(el) {
            if (!window.tempusDominus) {
                console.error('Tempus Dominus nije učitan.');
                return;
            }

            const ds = el.dataset;

            const opts = {
                localization: {
                    locale: 'hr', // hr-HR locale (učitaj prije ako koristiš lokalizaciju iz njihovog paketa)
                    startOfTheWeek: 1, // ponedjeljak
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
                    // icons: {
                    //     type: 'icons',
                    //     time: 'bi bi-clock',
                    //     date: 'bi bi-calendar',
                    //     up: 'bi bi-chevron-up',
                    //     down: 'bi bi-chevron-down',
                    //     previous: 'bi bi-chevron-left',
                    //     next: 'bi bi-chevron-right',
                    //     today: 'bi bi-calendar-check',
                    //     clear: 'bi bi-trash',
                    //     close: 'bi bi-x-lg'
                    // },

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


            const mode = (ds.mode || 'datetime');
            const restrictPast = (ds.restrictPast === 'true');
            const linkMin = ds.linkMin || null;
            const linkMax = ds.linkMax || null;
            const useBootstrapIcons = (ds.useBootstrapIcons === 'true');

            // Min/Max
            if (ds.minDate) opts.restrictions = Object.assign({}, opts.restrictions, {
                minDate: new Date(ds.minDate)
            });
            if (ds.maxDate) opts.restrictions = Object.assign({}, opts.restrictions, {
                maxDate: new Date(ds.maxDate)
            });

            if (restrictPast) {
                const now = new Date();
                opts.restrictions = Object.assign({}, opts.restrictions, {
                    minDate: now
                });
            }


            if (mode === 'date') {
                opts.display.components.clock = false;
                opts.display.components.hours = false;
                opts.display.components.minutes = false;
                opts.display.components.seconds = false;
            }

            // 24h sat
            if (ds.use24Hours === 'true') {
                opts.localization = Object.assign({}, opts.localization, {
                    hourCycle: 'h23'
                });
            }
            if (useBootstrapIcons) {
                opts.display = Object.assign({}, opts.display, {
                    icons: {
                        type: 'icons',
                        time: 'bi bi-clock',
                        date: 'bi bi-calendar',
                        up: 'bi bi-chevron-up',
                        down: 'bi bi-chevron-down',
                        previous: 'bi bi-chevron-left',
                        next: 'bi bi-chevron-right',
                        today: 'bi bi-calendar-check',
                        clear: 'bi bi-trash',
                        close: 'bi bi-x-lg'
                    }
                });
            }


            // Init
            opts.localization = Object.assign({}, opts.localization, {
                format: displayFormat
            });
            const picker = new tempusDominus.TempusDominus(el, opts);

            let currentRestrictions = Object.assign({}, opts.restrictions || {});

            // Prethodno postavljena vrijednost (ako postoji)
            if (el.value) {
                try {
                    picker.dates.setValue(new Date(el.value));
                } catch (e) {}
            }

            // Event – ažuriraj input on change
            el.addEventListener('change.td', (ev) => {
                // ev.target.value već sadrži string po formatu
                // Ako trebaš dodatni hidden input s ISO zapisom, ovdje ga možeš postaviti.
            });

            // Debug hook
            window['td_' + (el.id || el.name)] = picker;

            function getPickerById(id) {
                return window['td_' + id];
            }

            if (linkMin) {
                const src = getPickerById(linkMin);
                if (src) {
                    src.subscribe(tempusDominus.Namespace.events.change, (e) => {
                        if (e && e.date) {
                            currentRestrictions.minDate = e.date;
                            picker.updateOptions({
                                restrictions: currentRestrictions   
                            });
                        }
                    });
                }
            }

            if (linkMax) {
                const src = getPickerById(linkMax);
                if (src) {
                    src.subscribe(tempusDominus.Namespace.events.change, (e) => {
                        if (e && e.date) {
                            currentRestrictions.maxDate = e.date;
                            picker.updateOptions({ restrictions: currentRestrictions });

                            // picker.updateOptions({

                                
                            //     restrictions: Object.assign({}, picker.options.restrictions, {
                            //         maxDate: e.date
                            //     })
                            // });
                        }
                    });
                }
            }
        }

        function boot() {
            document.querySelectorAll('input.td-input, .td-wrapper input.td-input').forEach(initTd);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', boot, {
                once: true
            });
        } else {
            boot();
        }
    })();
</script>
@endPushOnce