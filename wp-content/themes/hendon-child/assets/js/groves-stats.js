/* Lazord Stats count-up — /projects/the-groves/ only */
(function () {
	'use strict';

	function formatNum(val, dec, sep, prefix) {
		var n;
		if (sep) {
			n = Number(val.toFixed(dec)).toLocaleString('en-US', {
				minimumFractionDigits: dec,
				maximumFractionDigits: dec
			});
		} else if (dec > 0) {
			n = val.toFixed(dec);
		} else {
			n = String(Math.round(val));
		}
		return (prefix || '') + n;
	}

	function animateNum(el) {
		if (el.dataset.lazordCounted === 'true') return;
		el.dataset.lazordCounted = 'true';

		var to = parseFloat(el.dataset.to);
		var dec = parseInt(el.dataset.dec || '0', 10);
		var sep = !!el.dataset.sep;
		var prefix = el.dataset.prefix || '';
		var duration = 1600;
		var start = null;

		/* Reset to zero — only done here, after confirming we will animate */
		el.textContent = formatNum(0, dec, sep, prefix);

		function easeOutCubic(t) { return 1 - Math.pow(1 - t, 3); }

		function tick(ts) {
			if (!start) start = ts;
			var progress = Math.min((ts - start) / duration, 1);
			el.textContent = formatNum(to * easeOutCubic(progress), dec, sep, prefix);
			if (progress < 1) {
				requestAnimationFrame(tick);
			} else {
				el.textContent = formatNum(to, dec, sep, prefix);
			}
		}

		requestAnimationFrame(tick);
	}

	function initLazordStats() {
		var section = document.querySelector('.lazord-stats');
		if (!section || section.dataset.lazordReady === 'true') return;
		section.dataset.lazordReady = 'true';

		var nums = section.querySelectorAll('.lazord-stats__num');
		if (!nums.length) return;

		var reducedMotion = window.matchMedia &&
			window.matchMedia('(prefers-reduced-motion: reduce)').matches;

		/* Degrade gracefully: numbers already show final value in HTML */
		if (reducedMotion || !('IntersectionObserver' in window)) return;

		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					animateNum(entry.target);
					io.unobserve(entry.target);
				}
			});
		}, { threshold: 0.4 });

		nums.forEach(function (el) { io.observe(el); });
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initLazordStats);
	} else {
		initLazordStats();
	}
})();
