/* nitaq-about-motion.js — scroll reveal + count-up for the About page */
(function () {
  'use strict';

  var DEBUG = window.location.search.indexOf('nitaq_motion_debug=1') !== -1;

  function log() {
    if (DEBUG) {
      var args = Array.prototype.slice.call(arguments);
      args.unshift('[Nitaq Motion]');
      console.log.apply(console, args);
    }
  }

  document.addEventListener('DOMContentLoaded', function () {

    log('Nitaq motion loaded');

    /* ── Guard: only run on About page ── */
    var page = document.querySelector('.nitaq-about-page');
    log('.nitaq-about-page found:', !!page);
    if (!page) return;

    /* ── Signal JS is active ── */
    document.body.classList.add('nitaq-motion-ready');

    /* ── Elements to animate ── */
    var SELECTORS = [
      /* Primary class-based selectors */
      '.nitaq-about-image',
      '.nitaq-about-feature__media',
      '.nitaq-about-copy',
      '.nitaq-about-feature__text',
      '.nitaq-about-heading',
      '.nitaq-about-duo article',
      '.nitaq-about-values article',
      '.nitaq-about-reasons span',
      '.nitaq-about-stats article',
      '.nitaq-about-hero__metrics > div',
      '.nitaq-about-signature .nitaq-about-container',
      '.nitaq-about-final .nitaq-about-container',
      /* Structural fallbacks */
      '.nitaq-about-page figure',
      '.nitaq-about-page article',
      '.nitaq-about-page .nitaq-about-split > div',
      '.nitaq-about-page .nitaq-about-feature > div'
    ];

    /* ── Fallback: no IntersectionObserver ── */
    if (!window.IntersectionObserver) {
      SELECTORS.forEach(function (sel) {
        try {
          document.querySelectorAll(sel).forEach(function (el) {
            el.classList.add('is-visible');
          });
        } catch (_e) {}
      });
      return;
    }

    /* ── Collect unique targets ── */
    var seen    = new WeakSet();
    var targets = [];

    SELECTORS.forEach(function (sel) {
      try {
        document.querySelectorAll(sel).forEach(function (el) {
          if (!seen.has(el)) {
            seen.add(el);
            targets.push(el);
          }
        });
      } catch (_e) {}
    });

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
    }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });

    targets.forEach(function (el) { revealObserver.observe(el); });

    /* ── Count-up (graceful no-op if markup not updated) ── */
    var statEls = document.querySelectorAll('.nitaq-stat-number');
    if (!statEls.length) return;

    function easeOutCubic(t) {
      return 1 - Math.pow(1 - t, 3);
    }

    function startCountUp(el) {
      var target    = parseFloat(el.dataset.target) || 0;
      var decimals  = parseInt(el.dataset.decimals || '0', 10);
      var duration  = 1800;
      var startTime = null;

      function tick(now) {
        if (!startTime) startTime = now;
        var elapsed  = now - startTime;
        var progress = Math.min(elapsed / duration, 1);
        var val      = target * easeOutCubic(progress);
        el.textContent = val.toLocaleString('en-US', {
          minimumFractionDigits: decimals,
          maximumFractionDigits: decimals
        });
        if (progress < 1) {
          requestAnimationFrame(tick);
        } else {
          el.textContent = target.toLocaleString('en-US', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
          });
        }
      }
      requestAnimationFrame(tick);
    }

    var counted      = new WeakSet();
    var statObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting || counted.has(entry.target)) return;
        counted.add(entry.target);
        startCountUp(entry.target);
        statObserver.unobserve(entry.target);
      });
    }, { threshold: 0.5 });

    statEls.forEach(function (el) { statObserver.observe(el); });

  });

}());


/* ── Trilogy cards scroll reveal ── */
(function () {
  if (!window.IntersectionObserver) {
    document.querySelectorAll('.nitaq-trilogy-card, .nitaq-trilogy-intro').forEach(function (el) {
      el.classList.add('is-visible');
    });
    return;
  }
  var trilogyObs = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (!entry.isIntersecting) return;
      var delay = parseInt(entry.target.getAttribute('data-delay') || '0', 10);
      setTimeout(function () {
        entry.target.classList.add('is-visible');
      }, delay);
      trilogyObs.unobserve(entry.target);
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll('.nitaq-trilogy-card, .nitaq-trilogy-intro').forEach(function (el) {
    trilogyObs.observe(el);
  });
}());
