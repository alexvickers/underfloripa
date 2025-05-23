/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */

(function () {
	var container, button, menu, links, i, len;

	container = document.getElementById('cm-primary-nav');
	if (!container) {
		return;
	}

	button = container.getElementsByClassName('cm-menu-toggle')[0];
	if ('undefined' === typeof button) {
		return;
	}

	menu = container.getElementsByTagName('ul')[0];

	// Hide menu toggle button if menu is empty and return early.
	if ('undefined' === typeof menu) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute('aria-expanded', 'false');
	if (-1 === menu.className.indexOf('nav-menu')) {
		menu.className += 'nav-menu';
	}

	button.onclick = function () {
		if (-1 !== container.className.indexOf('cm-mobile-nav')) {
			container.className = container.className.replace(
				'cm-mobile-nav',
				'cm-primary-nav',
			);
			button.setAttribute('aria-expanded', 'false');
			menu.setAttribute('aria-expanded', 'false');
		} else {
			container.className = container.className.replace(
				'cm-primary-nav',
				'cm-mobile-nav',
			);
			button.setAttribute('aria-expanded', 'true');
			menu.setAttribute('aria-expanded', 'true');
		}
	};

	// Get all the link elements within the menu.
	links = menu.getElementsByTagName('a');

	// Each time a menu link is focused or blurred, toggle focus.
	for (i = 0, len = links.length; i < len; i++) {
		links[i].addEventListener('focus', toggleFocus, true);
		links[i].addEventListener('blur', toggleFocus, true);
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while (-1 === self.className.indexOf('nav-menu')) {
			// On li elements toggle the class .focus.
			if ('li' === self.tagName.toLowerCase()) {
				if (-1 !== self.className.indexOf('focus')) {
					self.className = self.className.replace(' focus', '');
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	(function (container) {
		var touchStartFn,
			i,
			parentLink = container.querySelectorAll(
				'.menu-item-has-children > a, .page_item_has_children > a',
			);

		if (
			'ontouchstart' in window &&
			window.matchMedia('(min-width: 768px)').matches
		) {
			touchStartFn = function (e) {
				var menuItem = this.parentNode,
					i;

				if (!menuItem.classList.contains('focus')) {
					e.preventDefault();
					for (i = 0; i < menuItem.parentNode.children.length; ++i) {
						if (menuItem === menuItem.parentNode.children[i]) {
							continue;
						}

						menuItem.parentNode.children[i].classList.remove('focus');
					}
					menuItem.classList.add('focus');
				} else {
					menuItem.classList.remove('focus');
				}
			};

			for (i = 0; i < parentLink.length; ++i) {
				parentLink[i].addEventListener('touchstart', touchStartFn, false);
			}
		}
	})(container);
})();

(function () {
	const container = document.querySelector('.cm-mobile-nav-container');
	if (!container) return;
	const button = container.querySelector('.cm-menu-toggle');
	const menu = container.querySelector('.cm-mobile-menu');
	const mobileArea = container.querySelector('.cm-mobile-header-row');
	button.addEventListener('click', function (e) {
		e.preventDefault();
		const expanded = e.currentTarget.getAttribute('aria-expanded');
		if (expanded === 'false') {
			e.currentTarget.setAttribute('aria-expanded', 'true');
			menu.classList.add('cm-mobile-menu--open');
			mobileArea.classList.add('cm-mobile-menu--open');
		} else {
			e.currentTarget.setAttribute('aria-expanded', 'false');
			menu.classList.remove('cm-mobile-menu--open');
			mobileArea.classList.remove('cm-mobile-menu--open');
		}
	});
})();
