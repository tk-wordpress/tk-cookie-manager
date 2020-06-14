jQuery(document).ready(function($) {
	'use strict';

	(function TkCookieManagerAdmin() {
		var config = TkCookieManagerConfig;
		var form = $('#tk-cookie-manager-form');

		/**
		 * Add a new cookie group
		 *
		 * @param {object} cookieGroup
		 * @returns {object}
		 */
		var addCookieGroup = function(cookieGroup) {
			var template = $('#tk-cookie-manager-templates__cookies__cookie-group').html(),
				target = form.find('[data-target="cookie-group-container"]'),
				element;

			cookieGroup = $.extend({
				id: null,
				active: true,
				required: false,
				name: '',
				description: '',
				cookies: [],
			}, typeof cookieGroup !== 'undefined' ? cookieGroup : {});

			// Increment id for new cookie group
			if (cookieGroup.id === null) {
				cookieGroup.id
					= parseInt(form.find('[name="tk_cookie_manager[cookies][cookies][increment]"]').val()) + 1;

				form.find('[name="tk_cookie_manager[cookies][cookies][increment]"]').val(cookieGroup.id);
			}

			template = template
				.replace(/#groupId#/g, cookieGroup.id)
				.replace(/#active#/g, cookieGroup.active ? 'checked' : '')
				.replace(/#required#/g, cookieGroup.required ? 'checked' : '')
				.replace(/#name#/g, cookieGroup.name)
				.replace(/#description#/g, cookieGroup.description)
				.trim();

			element = target.append(template).sortable({
				handle: '.sort-handle',
				placeholder: 'ui-state--highlight',
			}).children().last();

			if (cookieGroup.cookies.length) {
				// Add cookies to cookie group
				$.each(cookieGroup.cookies, function(index, cookie) {
					addCookie(element, cookie);
				});
			}

			// Hide info box
			target.prev('.notice').hide();

			return element;
		};

		/**
		 * Add a new cookie
		 *
		 * @param {object} cookieGroup
		 * @param {object} cookie
		 * @returns {object}
		 */
		var addCookie = function(cookieGroup, cookie) {
			var template = $('#tk-cookie-manager-templates__cookies__cookie').html(),
				target = cookieGroup.find('[data-target="cookie-container"]');

			cookie = $.extend({
				active: true,
				name: '',
				provider: '',
				providerUrl: '',
				lifetime: '',
				cookieNames: '',
				description: '',
				html: '',
			}, typeof cookie !== 'undefined' ? cookie : {});

			template = template
				.replace(/#cookieId#/g, cookieGroup.attr('data-cookie-increment'))
				.replace(/#groupId#/g, cookieGroup.data('cookie-group-id'))
				.replace(/#active#/g, cookie.active ? 'checked' : '')
				.replace(/#name#/g, cookie.name)
				.replace(/#provider#/g, cookie.provider)
				.replace(/#providerUrl#/g, cookie.providerUrl)
				.replace(/#lifetime#/g, cookie.lifetime)
				.replace(/#cookieNames#/g, cookie.cookieNames)
				.replace(/#description#/g, cookie.description)
				.replace(/#html#/g, cookie.html)
				.trim();

			// Increment the cookie counter
			cookieGroup.find('[data-cookies]').text(parseInt(cookieGroup.find('[data-cookies]').text()) + 1);
			cookieGroup.attr('data-cookie-increment', parseInt(cookieGroup.attr('data-cookie-increment')) + 1);

			target.append(template).sortable({
				handle: '.sort-handle',
				placeholder: 'ui-state--highlight',
			});

			// Hide info box
			target.prev('.notice').hide();

			return target.children().last();
		};

		/**
		 * Initialize instances of editors
		 *
		 * @param {string} id
		 */
		var initEditor = function(id) {
			var element = $('#' + id);

			if (element.data('editor') === 'wysiwyg') {
				wp.editor.initialize(id, {
					tinymce: {
						plugins: config.editor.plugins,
						toolbar1: config.editor.toolbar1,
						toolbar2: config.editor.toolbar2,
					},
					quicktags: config.editor.quicktags,
					mediaButtons: config.editor.mediaButtons,
				});
			} else {
				var settings = wp.codeEditor.defaultSettings ? _.clone(wp.codeEditor.defaultSettings) : {};

				settings.codemirror = _.extend(
					{},
					settings.codemirror,
					{
						mode: element.data('editor'),
					}
				);

				// Delay initialization of code editor until sliding has finished
				window.setTimeout(function() {
					wp.codeEditor.initialize(element, settings);
				}, 250);
			}
		};

		// Initialize all initially available editors
		form.find('[data-editor]').each(function() {
			if ($(this).attr('id').indexOf('#') === -1) {
				initEditor($(this).attr('id'));
			}
		});

		// Register click event to add new cookie groups
		form.on('click', '[data-action="add-cookie-group"]', function() {
			var cookieGroup = addCookieGroup();

			// Trigger edit click to open item body
			cookieGroup.find('> .item-header').trigger('click');
			// Focus name field of newly added cookie group
			cookieGroup.find('[data-trigger="cookie-group-title"]').focus();
		});

		// Register click event to add new cookies
		form.on('click', '[data-action="add-cookie"]', function() {
			var cookie = addCookie($(this).closest('li'));

			// Trigger edit click to open item body
			cookie.find('> .item-header').trigger('click');
			// Focus name field of newly added cookie
			cookie.find('[data-trigger="cookie-title"]').focus();
		});

		// Register click event to toggle item body of element
		form.on('click', '.item-header', function() {
			var item = $(this).closest('li'),
				body = item.children('.item-body');

			if (!body.is(':visible') && body.attr('data-editors')) {
				$.each(body.attr('data-editors').split(' '), function(index, editor) {
					initEditor(item.attr('id') + '__' + editor);
				});

				body.removeAttr('data-editors');
			}

			$(this).closest('li').toggleClass('active').children('.item-body').slideToggle(250);
		});

		// Register click event to remove items
		form.on('click', '[data-action="delete"]', function(event) {
			event.stopPropagation();

			// Check if the deletion is confirmed and then drop the row
			if ($(this).hasClass('dashicons-yes')) {
				var target = $(this).closest('ul'),
					parent = target.closest('li');

				$(this).closest('li').remove();

				if (!target.children().length) {
					// Show info box again if the last element was removed
					target.prev().show();
				}

				if (parent.length) {
					parent.find('[data-cookies]').text(parseInt(parent.find('[data-cookies]').text()) - 1);
				}
			} else {
				$(this).toggleClass('dashicons-trash dashicons-yes');

				// Disable delete confirmation after 5 seconds
				window.setTimeout(function(obj) {
					obj.toggleClass('dashicons-trash dashicons-yes');
				}, 5000, $(this));
			}
		});

		// Register onkeyup event for item name to set item title
		form.on('keyup', '[data-trigger="cookie-group-title"], [data-trigger="cookie-title"]', function() {
			$(this).closest('li').find('> .item-header [data-target="title"]').text($(this).val());
		});

		// Remove templates before submitting form
		form.submit(function() {
			$(this).find('[data-template-container]').remove();
		});

		// Build already configured cookie groups
		$.each(config.cookieGroups, function(index, cookieGroup) {
			addCookieGroup(cookieGroup);
		});

		// Toggle containers for individual fields
		form.find('[data-toggle-container]').change(function() {
			var container = form.find($(this).data('toggle-container'));

			if ($(this).data('toggle-values').split(',').indexOf($(this).val()) > -1) {
				container.show().find('input, select, textarea').first().focus();
			} else {
				container.hide();
			}
		});

		form.submit(function(event) {
			form.parent().removeClass('was-validated');

			// Disable hidden fields to skip them during validation
			form.find('[data-toggle-container]').each(function() {
				form.find($(this).data('toggle-container'))
					.find('input, select, textarea')
					.prop('disabled', $(this).data('toggle-values').split(',').indexOf($(this).val()) === -1);
			});

			if (!form.get(0).checkValidity()) {
				form.parent().addClass('was-validated');

				event.preventDefault();
				event.stopPropagation();

				// Toggle item bodies with invalid form inputs
				$(':invalid')
					.parentsUntil('#tk-cookie-manager-form', 'li:not(.active)')
					.find('> .item-header')
					.trigger('click');
			}
		});
	})();
});
