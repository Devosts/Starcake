import './bootstrap';
import './echo';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

window.Alpine = Alpine;

Alpine.plugin(collapse);

/* ============================================================================
   STAR CAKE — "KOLOM"
   Interaction layer. Deliberately minimal: no ripple, no float, no glow,
   no number count-up. The interface is flat and typographic, so motion is
   limited to a restrained 8px reveal and a header rule that thickens.
   ========================================================================= */

/* ---------------------------------------------------------------------------
   SCROLL REVEAL — opacity + 8px, fires once
   ------------------------------------------------------------------------ */
function initScrollReveal() {
    const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
    if (!reveals.length) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        reveals.forEach((el) => el.classList.add('revealed'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
    );

    reveals.forEach((el) => observer.observe(el));
}

/* ---------------------------------------------------------------------------
   HEADER — swap the transparent hairline for a firm ink rule on scroll
   ------------------------------------------------------------------------ */
function initHeaderScroll() {
    const header = document.querySelector('[data-site-header]');
    if (!header) return;

    const update = () => {
        header.classList.toggle('header-scrolled', window.scrollY > 8);
    };

    update();
    window.addEventListener('scroll', update, { passive: true });
}

/* ---------------------------------------------------------------------------
   ANNOUNCEMENT BAR — dismissable, remembered for a day
   ------------------------------------------------------------------------ */
function initAnnouncementBar() {
    const bar = document.querySelector('.announcement-bar');
    if (!bar) return;

    if (document.cookie.includes('announcement_hidden=1')) {
        bar.remove();
        return;
    }

    const closeBtn = bar.querySelector('[data-dismiss]');
    if (!closeBtn) return;

    closeBtn.addEventListener('click', () => {
        bar.style.transition = 'height 0.2s ease, opacity 0.2s ease';
        bar.style.height = bar.offsetHeight + 'px';
        bar.style.overflow = 'hidden';
        requestAnimationFrame(() => {
            bar.style.height = '0';
            bar.style.opacity = '0';
        });
        setTimeout(() => {
            bar.remove();
            document.cookie = 'announcement_hidden=1; max-age=86400; path=/';
        }, 200);
    });
}

/* ---------------------------------------------------------------------------
   LAZY IMAGES — plain opacity fade on load
   ------------------------------------------------------------------------ */
function initLazyImages() {
    const images = document.querySelectorAll('img[data-src]');
    if (!images.length) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                const img = entry.target;
                img.addEventListener('load', () => {
                    img.style.opacity = '1';
                }, { once: true });
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            });
        },
        { rootMargin: '150px' }
    );

    images.forEach((img) => {
        img.style.opacity = '0';
        img.style.transition = 'opacity 0.35s linear';
        observer.observe(img);
    });
}

/* ---------------------------------------------------------------------------
   INIT
   ------------------------------------------------------------------------ */
function init() {
    initScrollReveal();
    initHeaderScroll();
    initAnnouncementBar();
    initLazyImages();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}

Alpine.start();
