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
        window.location.href = '/donate?amount=' + amount + '&cause=' + encodeURIComponent(causeText);
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

    /* ── Website Update Notification Modal ─────────────────────────────── */
    var modal = document.getElementById('daan-update-modal');
    if (modal) {
        function showModal() {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function hideModal() {
            modal.classList.remove('active');
            document.body.style.overflow = '';
            try {
                sessionStorage.setItem('daan_modal_dismissed', '1');
            } catch (e) {}
        }

        // Show only once per session
        var dismissed = false;
        try {
            dismissed = sessionStorage.getItem('daan_modal_dismissed') === '1';
        } catch (e) {}

        if (!dismissed) {
            // Small delay so the page renders first
            setTimeout(showModal, 600);
        }

        // Dismiss on close button, OK button, or overlay click
        modal.querySelector('.daan-modal-close').addEventListener('click', hideModal);
        modal.querySelector('.daan-modal-ok').addEventListener('click', hideModal);
        modal.addEventListener('click', function(e) {
            if (e.target === modal) hideModal();
        });

        // Dismiss on Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                hideModal();
            }
        });
    }

})();
