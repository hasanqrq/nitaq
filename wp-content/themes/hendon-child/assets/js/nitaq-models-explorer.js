/* nitaq-models-explorer.js — interactive model explorer for .nitaq-project-models */
(function () {
	'use strict';

	// Plan URL and floor data come from data-attributes set by the PHP renderer
	// (nitaq_model CPT via nitaq_model_cpt_explorer_markup()).
	// PLAN_MAP, FLOORS, getPlanUrl(), getFloors() removed — no hardcoded data.

	function init() {
		var grid = document.querySelector('.nitaq-project-models');
		if (!grid) { return; }

		var cards = grid.querySelectorAll('.nitaq-project-model-card');
		if (cards.length < 2) { return; }

		/* ── Extract data from PHP-rendered cards (CPT data-attributes) ── */
		var models = [];
		Array.prototype.forEach.call(cards, function (card) {
			var imgEl = card.querySelector('img');
			var h3El  = card.querySelector('h3');
			var pEl   = card.querySelector('p');
			if (!imgEl || !h3El) { return; }
			var name    = h3El.textContent.trim();
			var planUrl = card.dataset.planUrl || '';
			var floors  = card.dataset.floors ? JSON.parse(card.dataset.floors) : [];
			models.push({
				name:      name,
				body:      pEl ? pEl.textContent.trim() : '',
				renderUrl: imgEl.src,
				planUrl:   planUrl,
				floors:    floors
			});
		});

		if (models.length < 2) { return; } /* safety — leave original intact */

		/* ── State ── */
		var currentModel = 0;
		var currentView  = 'render';

		/* ── Build DOM ── */
		var explorer = document.createElement('div');
		explorer.className = 'nitaq-models-explorer';
		explorer.setAttribute('dir', 'rtl');

		/* Model selector pills */
		var modelTabsWrap = document.createElement('div');
		modelTabsWrap.className = 'nitaq-models-explorer__model-tabs';
		models.forEach(function (m, i) {
			var btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'nitaq-models-explorer__model-tab' + (i === 0 ? ' is-active' : '');
			btn.dataset.idx = String(i);
			btn.textContent = m.name;
			modelTabsWrap.appendChild(btn);
		});
		explorer.appendChild(modelTabsWrap);

		/* Panel */
		var panel = document.createElement('div');
		panel.className = 'nitaq-models-explorer__panel';

		/* View tabs (رندر / مخطط / تفاصيل) */
		var viewTabsWrap = document.createElement('div');
		viewTabsWrap.className = 'nitaq-models-explorer__view-tabs';
		[['render', 'رندر'], ['plan', 'مخطط'], ['details', 'تفاصيل']].forEach(function (pair, i) {
			var btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'nitaq-models-explorer__view-tab' + (i === 0 ? ' is-active' : '');
			btn.dataset.view = pair[0];
			btn.textContent = pair[1];
			viewTabsWrap.appendChild(btn);
		});
		panel.appendChild(viewTabsWrap);

		/* Image stage — two overlapping imgs for crossfade */
		var imgWrap = document.createElement('div');
		imgWrap.className = 'nitaq-models-explorer__img-wrap';

		var imgRender = document.createElement('img');
		imgRender.className = 'nitaq-models-explorer__img nitaq-models-explorer__img--render is-active';
		imgRender.src = models[0].renderUrl;
		imgRender.alt = models[0].name + ' — رندر';
		imgRender.setAttribute('loading', 'eager');

		var imgPlan = document.createElement('img');
		imgPlan.className = 'nitaq-models-explorer__img nitaq-models-explorer__img--plan';
		imgPlan.src = models[0].planUrl;
		imgPlan.alt = models[0].name + ' — مخطط';
		imgPlan.setAttribute('loading', 'lazy');

		imgWrap.appendChild(imgRender);
		imgWrap.appendChild(imgPlan);
		panel.appendChild(imgWrap);

		/* Detail panel — shown only when view === 'details' */
		var detailPanel = document.createElement('div');
		detailPanel.className = 'nitaq-models-explorer__detail-panel';
		detailPanel.style.display = 'none';
		panel.appendChild(detailPanel);

		/* Info block */
		var info = document.createElement('div');
		info.className = 'nitaq-models-explorer__info';

		var nameEl = document.createElement('h3');
		nameEl.className = 'nitaq-models-explorer__name';
		nameEl.textContent = models[0].name;

		var bodyEl = document.createElement('p');
		bodyEl.className = 'nitaq-models-explorer__body';
		bodyEl.textContent = models[0].body;

		info.appendChild(nameEl);
		info.appendChild(bodyEl);
		panel.appendChild(info);

		explorer.appendChild(panel);

		/* ── Inject: hide original grid, insert explorer after it ── */
		grid.setAttribute('data-nitaq-hidden', '1');
		grid.style.display = 'none';
		grid.parentNode.insertBefore(explorer, grid.nextSibling);

		/* ── Cache node lists ── */
		var modelTabs = explorer.querySelectorAll('.nitaq-models-explorer__model-tab');
		var viewTabs  = explorer.querySelectorAll('.nitaq-models-explorer__view-tab');

		/* ── Build detail panel content for a given model index ── */
		function buildDetailContent(idx) {
			detailPanel.innerHTML = '';
			var floors = models[idx].floors;
			if (!floors || floors.length === 0) {
				var empty = document.createElement('p');
				empty.className = 'nitaq-models-explorer__detail-empty';
				empty.textContent = 'لا تفاصيل متاحة';
				detailPanel.appendChild(empty);
				return;
			}
			floors.forEach(function (floor, fi) {
				var floorEl = document.createElement('div');
				floorEl.className = 'nitaq-models-explorer__floor' + (fi > 0 ? ' nitaq-models-explorer__floor--sep' : '');

				var labelEl = document.createElement('h4');
				labelEl.className = 'nitaq-models-explorer__floor-label';
				labelEl.textContent = floor.label;
				floorEl.appendChild(labelEl);

				var gridEl = document.createElement('div');
				gridEl.className = 'nitaq-models-explorer__room-grid';

				floor.rooms.forEach(function (room) {
					var row = document.createElement('div');
					row.className = 'nitaq-models-explorer__room-row';

					var nameSpan = document.createElement('span');
					nameSpan.className = 'nitaq-models-explorer__room-name';
					nameSpan.textContent = room.name;

					var sizeSpan = document.createElement('span');
					sizeSpan.className = 'nitaq-models-explorer__room-size';
					sizeSpan.textContent = room.size;

					row.appendChild(nameSpan);
					row.appendChild(sizeSpan);
					gridEl.appendChild(row);
				});

				floorEl.appendChild(gridEl);
				detailPanel.appendChild(floorEl);
			});
		}

		/* Populate for initial model */
		buildDetailContent(0);

		/* ── Interaction helpers ── */
		function setView(view) {
			currentView = view;
			Array.prototype.forEach.call(viewTabs, function (t) {
				t.classList.toggle('is-active', t.dataset.view === view);
			});
			if (view === 'details') {
				imgWrap.style.display = 'none';
				detailPanel.style.display = '';
				/* hide image-stage crossfade state to keep it clean on return */
				imgRender.classList.add('is-active');
				imgPlan.classList.remove('is-active');
			} else {
				detailPanel.style.display = 'none';
				imgWrap.style.display = '';
				if (view === 'render') {
					imgRender.classList.add('is-active');
					imgPlan.classList.remove('is-active');
				} else {
					imgPlan.classList.add('is-active');
					imgRender.classList.remove('is-active');
				}
			}
		}

		function setModel(idx) {
			currentModel = idx;
			Array.prototype.forEach.call(modelTabs, function (t) {
				t.classList.toggle('is-active', parseInt(t.dataset.idx, 10) === idx);
			});
			var m = models[idx];
			imgRender.src = m.renderUrl;
			imgRender.alt = m.name + ' — رندر';
			imgPlan.src   = m.planUrl;
			imgPlan.alt   = m.name + ' — مخطط';
			nameEl.textContent = m.name;
			bodyEl.textContent = m.body;
			buildDetailContent(idx);
			setView('render'); /* always reset to render on model switch */
		}

		Array.prototype.forEach.call(modelTabs, function (tab) {
			tab.addEventListener('click', function () {
				var idx = parseInt(this.dataset.idx, 10);
				if (idx !== currentModel) { setModel(idx); }
			});
		});

		Array.prototype.forEach.call(viewTabs, function (tab) {
			tab.addEventListener('click', function () {
				var view = this.dataset.view;
				if (view !== currentView) { setView(view); }
			});
		});

		/* Keyboard: arrow keys within model/view tab groups */
		function arrowNav(tabs, e) {
			var dir = (e.key === 'ArrowRight' || e.key === 'ArrowUp') ? -1 : 1;
			if (dir !== 1 && dir !== -1) { return; }
			var arr = Array.prototype.slice.call(tabs);
			var idx = arr.indexOf(document.activeElement);
			if (idx === -1) { return; }
			e.preventDefault();
			arr[(idx + dir + arr.length) % arr.length].focus();
		}
		modelTabsWrap.addEventListener('keydown', function (e) { arrowNav(modelTabs, e); });
		viewTabsWrap.addEventListener('keydown',  function (e) { arrowNav(viewTabs, e); });
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
