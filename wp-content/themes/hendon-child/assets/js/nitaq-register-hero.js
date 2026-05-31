/* nitaq-register-hero.js — video injection + header scroll for /register-interest/ */
(function () {
  'use strict';

  var VIDEO_SRC = 'https://nitaq-re.com/wp-content/uploads/2026/05/the-groves-20260514-185802.webm';
  var DEBUG = window.location.search.indexOf('nitaq_register_debug=1') !== -1;

  function log() {
    if (DEBUG) {
      var args = Array.prototype.slice.call(arguments);
      args.unshift('[Nitaq Register Hero]');
      console.log.apply(console, args);
    }
  }

  function injectVideo() {
    log('JS loaded');
    log('body classes:', document.body.className);

    if (!document.body.classList.contains('page-id-3340')) {
      log('not on page-id-3340 — aborting');
      return;
    }

    var hero = document.querySelector('.nitaq-register-hero');
    log('hero found:', !!hero);
    if (!hero) return;

    /* Avoid duplicate injection */
    if (hero.querySelector('.nitaq-register-hero__video')) {
      log('video already injected — skipping');
      return;
    }

    var video = document.createElement('video');
    video.className = 'nitaq-register-hero__video';
    video.autoplay = true;
    video.muted = true;
    video.loop = true;
    video.playsInline = true;
    video.preload = 'metadata';
    video.setAttribute('aria-hidden', 'true');

    var source = document.createElement('source');
    source.src = VIDEO_SRC;
    source.type = 'video/webm';
    video.appendChild(source);

    hero.insertBefore(video, hero.firstChild);
    hero.classList.add('nitaq-register-hero--has-video');

    log('video inserted:', true);
    log('video currentSrc:', video.currentSrc);
    log('video readyState:', video.readyState);

    video.play().then(function () {
      log('video playing');
    }).catch(function (err) {
      log('video play() failed:', err);
    });

    /* Header scroll: .nitaq-header-scrolled on body */
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

  /* Run on DOMContentLoaded; fall back to window.load if DOM already ready */
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', injectVideo);
  } else {
    injectVideo();
  }

  /* Safety net: run again on window.load if video still not injected */
  window.addEventListener('load', function () {
    var hero = document.querySelector('.nitaq-register-hero');
    if (hero && !hero.querySelector('.nitaq-register-hero__video')) {
      log('load fallback fired');
      injectVideo();
    }
  });

}());
