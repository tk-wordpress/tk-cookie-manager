TkCookieManager = window.TkCookieManager || {};
TkCookieManager = (function(window) {
	'use strict';

	var tkcm = {};

	// NodeList.forEach polyfill for Internet Explorer
	if (window.NodeList && !NodeList.prototype.forEach) {
		NodeList.prototype.forEach = Array.prototype.forEach;
	}

	tkcm.storage = (function() {
		var self = {
			data: null,
		};

		/**
		 * Load data from storage
		 *
		 * @param {boolean} reload
		 * @returns {object}
		 */
		self.get = function(reload) {
			// Return data, if it is already set
			if ((typeof reload === 'undefined' || !reload) && self.data !== null) {
				return self.data;
			}

			// Set default data
			self.data = {
				cookies: {
					cookiegroups: [],
					version: null,
				},
				platforms: [],
			}

			if (typeof Storage !== 'undefined') {
				// Local storage
				var data = localStorage.getItem('tk-cookie-manager');

				if (data) {
					self.data = JSON.parse(data);
				}
			} else {
				// Cookie fallback
				var cookie = decodeURIComponent(document.cookie).split(';');

				for (var i = 0; i < cookie.length; i++) {
					cookie[i] = cookie[i].trim();

					if (cookie[i].indexOf('tk-cookie-manager=') === 0) {
						self.data = JSON.parse(cookie[i].substring(18, cookie[i].length));

						break;
					}
				}
			}

			return self.data;
		};

		/**
		 * Save section data to storage
		 *
		 * @param {string} section
		 * @param sectionData
		 */
		self.set = function(section, sectionData) {
			var data = self.get();

			data[section] = sectionData;
			self.data = data;

			data = JSON.stringify(data);

			if (typeof Storage !== 'undefined') {
				// Local storage
				localStorage.setItem('tk-cookie-manager', data);
			} else {
				// Cookie fallback
				var date = new Date();

				date.setTime(date.getTime() + 365 * 24 * 60 * 60 * 1000); // 1 year

				document.cookie = 'tk-cookie-manager=' + data + ';expires=' + date.toUTCString() + ';path=/';
			}
		};

		return self;
	})();

	tkcm.infobox = (function() {
		var self = {
			container: document.getElementById('tk-cookie-manager-infobox'),
			includedCookieGroupJS: [],
		};

		/**
		 * Fade in cookie infobox
		 */
		self.show = function() {
			self.container.style.display = 'block';
			self.container.style.opacity = 0;

			(function fade() {
				var opacity = parseFloat(self.container.style.opacity);

				self.container.style.opacity = (opacity += .075);

				if (!(opacity > 1)) {
					requestAnimationFrame(fade);
				}
			})();
		};

		/**
		 * Fade out cookie infobox
		 */
		self.hide = function() {
			self.container.style.opacity = 1;

			(function fade() {
				if ((self.container.style.opacity -= .075) < 0) {
					self.container.style.display = 'none';
				} else {
					requestAnimationFrame(fade);
				}
			})();
		};

		/**
		 * Set selected checkboxes
		 *
		 * @param {int[]} cookieGroups
		 * @param {boolean} includeCookieGroupJS
		 */
		self.setup = function(cookieGroups, includeCookieGroupJS) {
			self.container.querySelectorAll('input[type="checkbox"]:not(:required)').forEach(function(checkbox) {
				checkbox.checked = cookieGroups && cookieGroups.indexOf(parseInt(checkbox.value)) > -1;
			});

			if (includeCookieGroupJS) {
				var json = JSON.parse(document.getElementById('tk-cookie-manager-cookiegroup-html').innerHTML),
					body = document.getElementsByTagName('body')[0],
					range;

				self.container.querySelectorAll('input[type="checkbox"]:checked').forEach(function(checkbox) {
					if (self.includedCookieGroupJS.indexOf(checkbox.value) === -1) {
						self.includedCookieGroupJS.push(checkbox.value);

						// Skip empty cookie groups
						if (json[checkbox.value]) {
							range = document.createRange();
							range.selectNode(body);

							body.appendChild(range.createContextualFragment(json[checkbox.value]));
						}
					}
				});
			}
		};

		/**
		 * Save selected cookie groups
		 */
		self.save = function() {
			var data = {
				cookieGroups: [],
				version: self.container.getAttribute('data-version'),
			};

			self.container.querySelectorAll('input[type="checkbox"]:checked').forEach(function(checkbox) {
				data.cookieGroups.push(parseInt(checkbox.value));
			});

			self.setup(data.cookieGroups, true);
			tkcm.storage.set('cookies', data);
		};

		// Show infobox if the stored version differs from the current version
		if (self.container.getAttribute('data-version') !== tkcm.storage.get().cookies.version) {
			self.setup(tkcm.storage.get().cookies.cookieGroups, false);

			if (!document.getElementsByTagName('body')[0].classList.contains('tk-disable-cookie-infobox')) {
				self.show();
			}
		} else {
			self.setup(tkcm.storage.get().cookies.cookieGroups, true);
		}

		// Open infobox on clicking manual open link
		document.querySelectorAll('[data-tk-cookie-manager-infobox-opener]').forEach(function(element) {
			element.addEventListener('click', function() {
				self.show();
			}, false);
		});

		// Show individual settings
		self.container
			.querySelector('.tk-cookie-manager-infobox__individual-settings-button')
			.addEventListener('click', function() {
				var wrapperClasses = self.container.querySelector('.tk-cookie-manager-infobox__wrapper').classList;

				wrapperClasses.remove('tk-cookie-manager-infobox__wrapper--state-simple');
				wrapperClasses.add('tk-cookie-manager-infobox__wrapper--state-advanced');
			});

		// Accept all cookies
		self.container
			.querySelector('.tk-cookie-manager-infobox__accept-all-button')
			.addEventListener('click', function() {
				self.container.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
					checkbox.checked = true;
				});

				self.save();
				self.hide();
			});

		// Accept selected cookies
		self.container
			.querySelector('.tk-cookie-manager-infobox__save-button')
			.addEventListener('click', function() {
				self.save();
				self.hide();
			});

		return self;
	})();

	tkcm.embeddedContents = (function() {
		var self = {};

		/**
		 * Allow embedding content for a platform
		 *
		 * @param {string} platform
		 */
		self.allow = function(platform) {
			var platforms = tkcm.storage.get().platforms;

			if (platforms.indexOf(platform) === -1) {
				platforms.push(platform);
				tkcm.storage.set('platforms', platforms);
			}
		};

		/**
		 * Allow embedding content for all platforms
		 */
		self.allowAll = function() {
			tkcm.storage.set('platforms', ['*']);
		};

		/**
		 * Disallow embedding content for a platform
		 *
		 * @param {string} platform
		 */
		self.disallow = function(platform) {
			var platforms = tkcm.storage.get().platforms,
				index = platforms.indexOf(platform);

			if (index > -1) {
				platforms.splice(index, 1);
				tkcm.storage.set('platforms', platforms);
			}
		};

		/**
		 * Disallow embedding content for all platforms
		 */
		self.disallowAll = function() {
			tkcm.storage.set('platforms', []);
		};

		/**
		 * Check if a platform is allowed
		 *
		 * @param {string} platform
		 * @returns {boolean}
		 */
		self.isAllowed = function(platform) {
			var platforms = tkcm.storage.get().platforms;

			return platforms.indexOf('*') > -1 || platforms.indexOf(platform) > -1;
		};

		/**
		 * Check if a platform is disallowed
		 *
		 * @param {string} platform
		 * @returns {boolean}
		 */
		self.isDisallowed = function(platform) {
			return !self.isAllowed(platform);
		};

		document.querySelectorAll('.tk-cookie-manager-embedded-contents-table input').forEach(function(element) {
			// Toggle input if platform is allowed
			if (self.isAllowed(element.value)) {
				element.checked = true;
			}

			// Add change event for platform togglers
			element.addEventListener('change', function() {
				if (element.checked) {
					self.allow(element.value);
				} else {
					self.disallow(element.value)
				}
			}, false);
		});

		document.querySelectorAll('.tk-cookie-manager-embed-spoiler').forEach(function(element) {
			// Trigger click event for allowed platform spoilers
			if (self.isAllowed(element.getAttribute('data-platform'))) {
				element.click();
			}

			// Add click event for embedded content spoilers
			element.addEventListener('click', function(event) {
				if (event.target.tagName.toLowerCase() !== 'a') {
					var jsonContainer = document.getElementById(element.getAttribute('data-id')),
						target = document.createElement('div');

					target.className = 'tk-cookie-manager-embed-container';
					target.innerHTML = JSON.parse(jsonContainer.innerHTML);

					self.allow(element.getAttribute('data-platform'));

					element.parentNode.replaceChild(target, element);
					jsonContainer.remove();
				}
			}, false);
		});

		return self;
	})();

	return tkcm;
})(window);
