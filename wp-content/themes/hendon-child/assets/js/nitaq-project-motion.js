/* nitaq-project-motion.js — scroll reveal for The Groves project page */
(function () {
  'use strict';

  var DEBUG = window.location.search.indexOf('nitaq_project_motion_debug=1') !== -1;

  function log() {
    if (DEBUG) {
      var args = Array.prototype.slice.call(arguments);
      args.unshift('[Nitaq Project Motion]');
      console.log.apply(console, args);
    }
  }

  document.addEventListener('DOMContentLoaded', function () {

    log('Nitaq project motion loaded');

    /* ── Guard: only run on project page ── */
    var page = document.querySelector('.nitaq-project-page');
    log('.nitaq-project-page found:', !!page);
    if (!page) return;

    /* ── Signal JS is active ── */
    document.body.classList.add('nitaq-project-motion-ready');

    /*
     * IMAGE selectors → get class nitaq-project-reveal--image
     *   fade + lift 32px + scale 1.025→1, duration 950ms
     *
     * TEXT selectors  → get class nitaq-project-reveal
     *   fade + lift 26px, duration 850ms
     *   (cards use the same base class; CSS handles their 24px / 880ms)
     */
    var IMAGE_SELECTORS = [
      '.nitaq-project-media',
      '.nitaq-project-wide-media',
      '.nitaq-project-model-card',
      '.nitaq-project-image-pair',
    ];

    var TEXT_SELECTORS = [
      '.nitaq-project-hero__content',
      '.nitaq-project-section-head',
      '.nitaq-project-grid--split > div',
      '.nitaq-project-text-card',
      '.nitaq-project-amenities',
      '.nitaq-project-cta > div',
    ];

    /* ── Fallback: no IntersectionObserver ── */
    if (!window.IntersectionObserver) {
      IMAGE_SELECTORS.concat(TEXT_SELECTORS).forEach(function (sel) {
        try {
          page.querySelectorAll(sel).forEach(function (el) {
            el.classList.add('is-visible');
          });
        } catch (_e) {}
      });
      return;
    }

    /* ── Collect unique targets and tag with reveal class ── */
    var seen    = new WeakSet();
    var targets = [];

    function collect(selectors, revealClass) {
      selectors.forEach(function (sel) {
        try {
          page.querySelectorAll(sel).forEach(function (el) {
            if (!seen.has(el)) {
              seen.add(el);
              el.classList.add(revealClass);
              targets.push(el);
            }
          });
        } catch (_e) {}
      });
    }

    /* Image selectors first so .nitaq-project-image-pair (a div inside
       .nitaq-project-grid--split) gets --image, not the plain text class */
    collect(IMAGE_SELECTORS, 'nitaq-project-reveal--image');
    collect(TEXT_SELECTORS,  'nitaq-project-reveal');

    log('observed elements count:', targets.length);

    /* ── Stagger siblings within the same parent (120ms per step) ── */
    var groups = new Map();
    targets.forEach(function (el) {
      var key = el.parentElement || document.body;
      if (!groups.has(key)) groups.set(key, []);
      groups.get(key).push(el);
    });
    groups.forEach(function (siblings) {
      siblings.forEach(function (el, i) {
        if (i > 0) el.style.setProperty('--nitaq-motion-delay', (i * 120) + 'ms');
      });
    });

    /* ── Reveal observer ── */
    var revealObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        log('is-visible:', entry.target.className || entry.target.tagName);
        entry.target.classList.add('is-visible');
        revealObserver.unobserve(entry.target);
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -24px 0px' });

    targets.forEach(function (el) { revealObserver.observe(el); });

  });

  /* ── Header scroll: add .nitaq-header-scrolled to document.body ──
     CSS targets body.single-nitaq_project.nitaq-header-scrolled  ── */
  function initHeaderScroll() {
    var hero = document.querySelector('.nitaq-project-hero');
    if (!hero) return;

    var threshold = (hero.offsetHeight * 0.55) || 400;

    function onScroll() {
      if (window.scrollY > threshold) {
        document.body.classList.add('nitaq-header-scrolled');
      } else {
        document.body.classList.remove('nitaq-header-scrolled');
      }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  if (document.querySelector('.nitaq-project-page')) {
    document.addEventListener('DOMContentLoaded', initHeaderScroll);
  }

}());
