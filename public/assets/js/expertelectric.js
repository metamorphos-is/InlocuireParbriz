(function () {
    'use strict';

    // Meniu mobil
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
                toggle.focus();
            }
        });
    }

    // Formular: marchează câmpurile invalide la trimitere (validare nativă ca plasă de siguranță)
    document.querySelectorAll('form.ee-form').forEach(function (form) {
        var btn = form.querySelector('button[type="submit"]');
        form.addEventListener('submit', function () {
            if (btn && form.checkValidity()) {
                btn.disabled = true;
                btn.setAttribute('aria-busy', 'true');
            }
        });
    });
})();
