(function () {
    'use strict';

    /* ---------- Header + mega-menu (ip-*) ---------- */
    var burger = document.querySelector('[data-ip-burger]');
    var nav = document.querySelector('[data-ip-nav]');
    var desktop = window.matchMedia('(min-width: 1200px)');
    var drops = Array.prototype.slice.call(document.querySelectorAll('[data-ip-drop]'));
    var hoverTimer = null;

    function setDrop(item, open) {
        if (open && !item.classList.contains('is-open')) item._openedAt = Date.now();
        item.classList.toggle('is-open', open);
        var btn = item.querySelector('[data-ip-drop-btn]');
        if (btn) btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    }
    function closeAll(except) {
        drops.forEach(function (item) { if (item !== except) setDrop(item, false); });
    }

    drops.forEach(function (item) {
        var btn = item.querySelector('[data-ip-drop-btn]');
        if (!btn) return;
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var isOpen = item.classList.contains('is-open');
            // Desktop: dacă meniul tocmai s-a deschis la hover, click-ul nu-l închide.
            if (isOpen && desktop.matches && Date.now() - (item._openedAt || 0) < 600) return;
            closeAll(item);
            setDrop(item, !isOpen);
        });
        // Desktop: deschidere la hover, cu mică întârziere la ieșire.
        item.addEventListener('mouseenter', function () {
            if (!desktop.matches) return;
            clearTimeout(hoverTimer);
            closeAll(item);
            setDrop(item, true);
        });
        item.addEventListener('mouseleave', function () {
            if (!desktop.matches) return;
            hoverTimer = setTimeout(function () { setDrop(item, false); }, 180);
        });
    });

    document.addEventListener('click', function (e) {
        if (desktop.matches && !e.target.closest('[data-ip-drop]')) closeAll();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        var open = drops.filter(function (d) { return d.classList.contains('is-open'); })[0];
        if (open) {
            setDrop(open, false);
            var b = open.querySelector('[data-ip-drop-btn]');
            if (b) b.focus();
        } else if (nav && nav.classList.contains('is-open')) {
            nav.classList.remove('is-open');
            burger.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
            burger.focus();
        }
    });

    if (burger && nav) {
        burger.addEventListener('click', function () {
            var open = nav.classList.toggle('is-open');
            burger.setAttribute('aria-expanded', open ? 'true' : 'false');
            document.body.style.overflow = open ? 'hidden' : '';
            if (!open) closeAll();
        });
        desktop.addEventListener('change', function () {
            nav.classList.remove('is-open');
            burger.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
            closeAll();
        });
    }

    // Taburi „Locații” (hover/click pe regiune → schimbă panoul).
    document.querySelectorAll('[data-ip-tabs]').forEach(function (wrap) {
        var tabs = wrap.querySelectorAll('[data-ip-tab]');
        function show(key) {
            tabs.forEach(function (t) {
                var on = t.getAttribute('data-ip-tab') === key;
                t.classList.toggle('is-active', on);
                t.setAttribute('aria-selected', on ? 'true' : 'false');
            });
            wrap.querySelectorAll('[data-ip-panel]').forEach(function (p) {
                p.hidden = p.getAttribute('data-ip-panel') !== key;
            });
        }
        tabs.forEach(function (t) {
            t.addEventListener('click', function () { show(t.getAttribute('data-ip-tab')); });
            t.addEventListener('mouseenter', function () { if (desktop.matches) show(t.getAttribute('data-ip-tab')); });
        });
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
        var isBucharest = area.value === 'bucuresti';
        var isIlfov = area.value === 'ilfov';
        sectorWrap.hidden = !isBucharest;
        localityWrap.hidden = isBucharest;
        if (sector) {
            sector.required = isBucharest;
            if (!isBucharest) sector.value = '';
        }
        var locality = form.querySelector('#locality');
        var label = form.querySelector('[data-locality-label]');
        if (locality) {
            locality.required = !isBucharest;
            locality.placeholder = isIlfov ? locality.dataset.placeholderIlfov : locality.dataset.placeholderOther;
        }
        if (label) label.textContent = isIlfov ? label.dataset.labelIlfov : label.dataset.labelOther;
    }

    document.querySelectorAll('[data-lead-form]').forEach(function (form) {
        var area = form.querySelector('[data-area-type]');
        if (area) {
            area.addEventListener('change', function () { syncArea(form); });
            syncArea(form);
        }
    });
})();
