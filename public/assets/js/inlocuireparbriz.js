(function () {
    'use strict';

    var toggle = document.querySelector('[data-nav-toggle]');
    var nav = document.querySelector('[data-nav]');
    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            var open = nav.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && nav.classList.contains('is-open')) {
                nav.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
                closeAllDrops();
                toggle.focus();
            }
        });
    }

    function closeAllDrops(except) {
        document.querySelectorAll('[data-nav-drop]').forEach(function (item) {
            if (except && item === except) return;
            item.classList.remove('is-open');
            var btn = item.querySelector('[data-nav-drop-btn]');
            if (btn) btn.setAttribute('aria-expanded', 'false');
        });
    }

    document.querySelectorAll('[data-nav-drop]').forEach(function (item) {
        var btn = item.querySelector('[data-nav-drop-btn]');
        if (!btn) return;
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var open = !item.classList.contains('is-open');
            closeAllDrops();
            if (open) {
                item.classList.add('is-open');
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('[data-nav-drop]')) {
            closeAllDrops();
        }
    });

    document.querySelectorAll('form.ee-form').forEach(function (form) {
        var btn = form.querySelector('button[type="submit"]');
        form.addEventListener('submit', function () {
            if (btn && form.checkValidity()) {
                btn.disabled = true;
                btn.setAttribute('aria-busy', 'true');
            }
        });
    });

    function syncArea(form) {
        var area = form.querySelector('[data-area-type]');
        var sectorWrap = form.querySelector('[data-sector-wrap]');
        var localityWrap = form.querySelector('[data-locality-wrap]');
        var sector = form.querySelector('[data-sector-select]');
        if (!area || !sectorWrap || !localityWrap) return;
        var isIlfov = area.value === 'ilfov';
        sectorWrap.hidden = isIlfov;
        localityWrap.hidden = !isIlfov;
        if (sector) {
            sector.required = !isIlfov;
            if (isIlfov) sector.value = '';
        }
        var locality = form.querySelector('#locality');
        if (locality) locality.required = isIlfov;
    }

    document.querySelectorAll('[data-lead-form]').forEach(function (form) {
        var area = form.querySelector('[data-area-type]');
        if (area) {
            area.addEventListener('change', function () { syncArea(form); });
            syncArea(form);
        }
    });
})();
