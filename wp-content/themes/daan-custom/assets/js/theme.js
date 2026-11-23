/**
 * Daan Custom Theme — Main Script
 * Hero crossfade, mobile menu, donation widget
 */
(function() {
    'use strict';

    /* ── Sticky Header Shadow ─────────────────────────────────────────── */
    const header = document.getElementById('masthead');
    if (header) {
        let ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    header.classList.toggle('scrolled', window.scrollY > 10);
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
    }

    /* ── Hero Slideshow ────────────────────────────────────────────────── */
    const slides = document.querySelectorAll('.hero-slide');
    if (slides.length > 1) {
        let current = 0;
        setInterval(function() {
            slides[current].style.opacity = '0';
            current = (current + 1) % slides.length;
            slides[current].style.opacity = '1';
        }, 3500);
    }

    /* ── Mobile Menu Toggle ────────────────────────────────────────────── */
    const toggleBtn = document.getElementById('menu-toggle');
    const mobileNav = document.getElementById('mobile-nav');
    const openIcon = document.querySelector('.menu-icon-open');
    const closeIcon = document.querySelector('.menu-icon-close');

    if (toggleBtn && mobileNav) {
        new MutationObserver(function() {
            toggleBtn.setAttribute('aria-expanded', mobileNav.classList.contains('open') ? 'true' : 'false');
        }).observe(mobileNav, { attributes: true, attributeFilter: ['class'] });

        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpen = mobileNav.classList.toggle('open');
            if (openIcon) openIcon.style.display = isOpen ? 'none' : 'block';
            if (closeIcon) closeIcon.style.display = isOpen ? 'block' : 'none';
            document.body.style.overflow = isOpen ? 'hidden' : '';
        });

        // Close mobile menu on outside click
        document.addEventListener('click', function(e) {
            if (mobileNav.classList.contains('open') &&
                !mobileNav.contains(e.target) &&
                !toggleBtn.contains(e.target)) {
                mobileNav.classList.remove('open');
                if (openIcon) openIcon.style.display = 'block';
                if (closeIcon) closeIcon.style.display = 'none';
                document.body.style.overflow = '';
            }
        });

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileNav.classList.contains('open')) {
                mobileNav.classList.remove('open');
                if (openIcon) openIcon.style.display = 'block';
                if (closeIcon) closeIcon.style.display = 'none';
                document.body.style.overflow = '';
            }
        });
    }

    /* ── Mobile Submenu Toggle ─────────────────────────────────────────── */
    window.toggleMobileSubmenu = function(btn) {
        const submenu = btn.nextElementSibling;
        const chevron = btn.querySelector('.mobile-nav-chevron');
        if (submenu) {
            submenu.classList.toggle('open');
            if (chevron) chevron.classList.toggle('open');
        }
    };

    /* ── Donation Widget ───────────────────────────────────────────────── */
    let selectedAmount = 1000;
    let customAmount = '';

    window.selectAmount = function(btn, amount) {
        // Clear all active states
        document.querySelectorAll('.amount-btn').forEach(function(b) {
            b.classList.remove('active');
        });
        btn.classList.add('active');

        selectedAmount = amount;
        customAmount = '';

        const input = btn.closest('.donation-widget')?.querySelector('.custom-amount');
        if (input) input.value = '';
    };

    window.clearAmounts = function(input) {
        document.querySelectorAll('.amount-btn').forEach(function(b) {
            b.classList.remove('active');
        });
        selectedAmount = null;
        customAmount = input.value;
    };

    window.handleDonate = function() {
        const cause = document.getElementById('donate-cause');
        const amount = customAmount || selectedAmount || 0;
        const causeText = cause ? cause.value : 'Where Most Needed';
        window.location.href = '/donate/?amount=' + amount + '&cause=' + encodeURIComponent(causeText);
    };

    /* ── Fixed-price causes in the widgets (meals, kits): choose a number, total = number × price ── */
    var FIXED = window.DAAN_FIXED || {};
    var LIMIT = window.DAAN_MAX || 1000000;
    function inr(n) { return '₹' + n.toLocaleString('en-IN'); }
    function fixedFor(cause) { return Object.prototype.hasOwnProperty.call(FIXED, cause) ? FIXED[cause] : null; }

    document.querySelectorAll('[data-daan-donate]').forEach(function(root) {
        var sel = root.querySelector('select');
        var free = root.querySelector('[data-daan-free]');
        if (!sel || !free) return;
        var box = document.createElement('div');
        box.style.cssText = 'display:none;margin-bottom:16px;';
        free.parentNode.insertBefore(box, free.nextSibling);
        // The cause comes first when a number is needed: move the cause list above the amount area.
        var causeWrap = sel.parentNode;
        root.daanQty = 1;

        // Fixed-price causes: one stepper [ − ] [n] [ + ] with a live total (window.daanStepper, inc/donation-stepper.php).
        function render() {
            var f = fixedFor(sel.value);
            free.style.display = f ? 'none' : '';
            box.style.display = f ? 'block' : 'none';
            if (!f) return;
            var max = Math.max(1, Math.floor(LIMIT / f.unit));
            root.daanQty = 1;
            box.innerHTML = '';
            if (typeof window.daanStepper !== 'function') return;
            box.appendChild(window.daanStepper({
                label: window.daanQtyLabel(sel.value, f),
                note: inr(f.unit) + ' per ' + f.one,
                unit: f.unit, max: max, value: 1,
                onChange: function(n) { root.daanQty = n; }
            }));
        }
        // Cause list above the amounts, so the amount area follows the cause.
        if (causeWrap && causeWrap !== root && causeWrap.parentNode === free.parentNode) {
            free.parentNode.insertBefore(causeWrap, free);
        }
        sel.addEventListener('change', render);
        render();
    });

    window.daanWidgetGo = function(btn) {
        var root = btn.closest('[data-daan-donate]');
        var sel = root ? root.querySelector('select') : null;
        var cause = sel ? sel.value : 'Where Most Needed';
        var f = fixedFor(cause);
        if (f) {
            var max = Math.max(1, Math.floor(LIMIT / f.unit));
            var q = root.daanQty || 0;
            if (q < 1 || q > max) { alert('Please choose between 1 and ' + max + ' ' + f.many + '.'); return; }
            window.location.href = '/donate/?cause=' + encodeURIComponent(cause) + '&qty=' + q;
            return;
        }
        var custom = root ? root.querySelector('.custom-amount') : null;
        var active = root ? root.querySelector('.amount-btn.active') : null;
        var amount = (custom && parseInt(custom.value, 10) > 0) ? parseInt(custom.value, 10) : (active ? active.getAttribute('data-amount') : 1000);
        window.location.href = '/donate/?amount=' + amount + '&cause=' + encodeURIComponent(cause);
    };

    /* ── Smooth Scroll for anchor links ────────────────────────────────── */
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            const href = anchor.getAttribute('href');
            if (href && href.length > 1) {
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });

})();
