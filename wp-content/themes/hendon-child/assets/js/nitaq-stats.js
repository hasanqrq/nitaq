/* nitaq-stats.js — count-up for .nitaq-stat-num on single project pages */
(function () {
	'use strict';

	var DURATION = 1600;

	function easeOutCubic(t) {
		return 1 - Math.pow(1 - t, 3);
	}

	/**
	 * Parse a data-final string like "+3.9", "+8,100", "19%", "+33", "778"
	 * Returns { prefix, value, decimals, useSep, suffix }
	 */
	function parse(str) {
		str = String(str).trim();

		// Leading non-numeric prefix (e.g. "+", "-")
		var prefixMatch = str.match(/^([^0-9]*)/);
		var prefix = prefixMatch ? prefixMatch[1] : '';
		var rest = str.slice(prefix.length);

		// Trailing non-numeric suffix (e.g. "%")
		var suffixMatch = rest.match(/([^0-9]*)$/);
		var suffix = suffixMatch ? suffixMatch[1] : '';
		var mid = rest.slice(0, rest.length - suffix.length);

		// Detect thousands separator (comma in numeric part)
		var useSep = mid.indexOf(',') !== -1;
		mid = mid.replace(/,/g, '');

		var value = parseFloat(mid);
		if (isNaN(value)) { value = 0; }

		var decimals = 0;
		var dotPos = mid.indexOf('.');
		if (dotPos !== -1) {
			decimals = mid.length - dotPos - 1;
		}

		return { prefix: prefix, value: value, decimals: decimals, useSep: useSep, suffix: suffix };
	}

	function format(p, current) {
		var n;
		if (p.useSep) {
			n = Number(current.toFixed(p.decimals)).toLocaleString('en-US', {
				minimumFractionDigits: p.decimals,
				maximumFractionDigits: p.decimals
			});
		} else {
			n = current.toFixed(p.decimals);
		}
		return p.prefix + n + p.suffix;
	}

	function animateEl(el, parsed) {
		if (el.dataset.nitaqCounted === 'true') { return; }
		el.dataset.nitaqCounted = 'true';

		var start = null;
		el.textContent = format(parsed, 0);

		function tick(ts) {
			if (!start) { start = ts; }
			var progress = Math.min((ts - start) / DURATION, 1);
			el.textContent = format(parsed, parsed.value * easeOutCubic(progress));
			if (progress < 1) {
				requestAnimationFrame(tick);
			} else {
				el.textContent = format(parsed, parsed.value);
			}
		}

		requestAnimationFrame(tick);
	}

	function init() {
		var nums = document.querySelectorAll('.nitaq-stat-num');
		if (!nums.length) { return; }

		// Respect prefers-reduced-motion; degrade gracefully if no IO support
		var reducedMotion = window.matchMedia &&
			window.matchMedia('(prefers-reduced-motion: reduce)').matches;

		if (reducedMotion || !('IntersectionObserver' in window)) {
			return; // leave the HTML-rendered final values untouched
		}

		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					var el = entry.target;
					var parsed = parse(el.dataset.final || el.textContent);
					animateEl(el, parsed);
					io.unobserve(el);
				}
			});
		}, { threshold: 0.4 });

		Array.prototype.forEach.call(nums, function (el) {
			io.observe(el);
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
